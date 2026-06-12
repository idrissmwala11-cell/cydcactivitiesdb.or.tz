<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class PerformanceReportController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $period = $request->get('period', 'weekly');

        [$startDate, $endDate, $periodLabel] = $this->resolvePeriod($period);

        $reportData = $this->buildReportData($startDate, $endDate);

        $summary = $this->buildSummary($reportData);

        return view('admin.performance-report.index', compact(
            'reportData',
            'period',
            'periodLabel',
            'startDate',
            'endDate',
            'summary'
        ));
    }

    public function generate(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'period' => ['required', 'in:weekly,monthly,bimonthly'],
        ]);

        $period = $request->period;

        [$startDate, $endDate, $periodLabel] = $this->resolvePeriod($period);

        $reportData = $this->buildReportData($startDate, $endDate);

        $summary = $this->buildSummary($reportData);

        return view('admin.performance-report.index', compact(
            'reportData',
            'period',
            'periodLabel',
            'startDate',
            'endDate',
            'summary'
        ));
    }

    protected function authorizeAdmin(): void
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized. Admin access only.');
        }
    }

    /**
     * 🔥 PERIOD LOGIC (IMPROVED)
     */
    protected function resolvePeriod(string $period): array
    {
        if ($period === 'bimonthly') {

            // Last 2 months (current + previous)
            $startDate = Carbon::now()->subMonth()->startOfMonth()->startOfDay();
            $endDate = Carbon::now()->endOfMonth()->endOfDay();
            $periodLabel = 'Last 2 Months';

        } elseif ($period === 'monthly') {

            $startDate = Carbon::now()->startOfMonth()->startOfDay();
            $endDate = Carbon::now()->endOfMonth()->endOfDay();
            $periodLabel = 'Monthly';

        } else {

            $startDate = Carbon::now()->startOfWeek()->startOfDay();
            $endDate = Carbon::now()->endOfWeek()->endOfDay();
            $periodLabel = 'Weekly';
        }

        return [$startDate, $endDate, $periodLabel];
    }

    /**
     * 🔥 CORE REPORT ENGINE (OPTIMIZED)
     */
    protected function buildReportData(Carbon $startDate, Carbon $endDate): Collection
    {
        $modules = config('performance_reports.modules', []);

        $centers = User::query()
            ->whereNotNull('center_id')
            ->where('center_id', '!=', '')
            ->distinct()
            ->orderBy('center_id')
            ->pluck('center_id');

        $reportData = collect();

        foreach ($centers as $centerId) {

            $userIds = User::where('center_id', $centerId)->pluck('id');

            $totalRecords = 0;

            foreach ($modules as $module) {

                $modelClass = $module['model'] ?? null;
                $dateField = $module['date_field'] ?? 'created_at';

                if (!$modelClass || !class_exists($modelClass)) {
                    continue;
                }

                $modelInstance = new $modelClass;
                $table = $modelInstance->getTable();

                if (!Schema::hasColumn($table, 'user_id') || !Schema::hasColumn($table, $dateField)) {
                    continue;
                }

                $count = $modelClass::whereIn('user_id', $userIds)
                    ->whereBetween($dateField, [$startDate, $endDate])
                    ->count();

                $totalRecords += $count;
            }

            $reportData->push([
                'center_id' => $centerId,
                'total_users' => $userIds->count(),
                'total_records' => $totalRecords,
                'percentage' => 0,
                'rank' => null,
                'status' => $totalRecords > 0 ? 'Active' : 'Inactive',
            ]);
        }

        $topCenterTotal = $reportData->max('total_records') ?? 0;

        return $reportData
            ->map(function ($item) use ($topCenterTotal) {

                $item['percentage'] = $topCenterTotal > 0
                    ? round(($item['total_records'] / $topCenterTotal) * 100, 2)
                    : 0;

                return $item;
            })
            ->sortByDesc('total_records')
            ->values()
            ->map(function ($item, $index) {
                $item['rank'] = $index + 1;
                return $item;
            });
    }

    /**
     * 🔥 SUMMARY (IMPROVED)
     */
    protected function buildSummary(Collection $reportData): array
    {
        $topCenter = $reportData->first();

        return [
            'total_centers' => $reportData->count(),
            'active_centers' => $reportData->where('total_records', '>', 0)->count(),
            'inactive_centers' => $reportData->where('total_records', 0)->count(),
            'top_center_id' => $topCenter['center_id'] ?? 'N/A',
            'top_center_records' => $topCenter['total_records'] ?? 0,
        ];
    }
}