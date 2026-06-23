<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;
use App\Models\Submission;
use App\Models\User;
use App\Models\ParentsInformation;
use App\Models\BaseLeader;
use App\Models\MasomoYaMtaala;
use App\Models\HomeVisitation;
use App\Models\SchoolVisitation;
use App\Models\LocalSponsorship;
use App\Models\CenterLeadership;
use App\Models\TalentsInformation;
use App\Models\SkillsInformation;
use App\Models\SkillsAttendance;
use App\Models\CurriculumAttendance;
use App\Models\TalentAttendance;
use App\Models\SpecialProgram;
use App\Models\SchoolInformationRecord;
use App\Models\ExamResult;

class ReportController extends Controller
{
    /**
     * Display reports page.
     */
    public function index(): View
    {
        $modules = $this->getModules();
        $user = Auth::user();
        $examClassLevelOptions = $this->getExamClassLevelOptions();

        return view('reports.index', compact('modules', 'user', 'examClassLevelOptions'));
    }

    /**
     * Run selected report.
     */
    public function run(Request $request): View|RedirectResponse
    {
        $request->validate([
            'module' => ['required', 'string'],
            'center_id' => ['nullable', 'string'],
            'period' => ['nullable', 'in:all,week,month,3months,6months'],
            'class_level' => ['nullable', 'string'],
        ]);

        $modules = $this->getModules();
        $moduleKey = $request->module;
        $examClassLevelOptions = $this->getExamClassLevelOptions();

        if (!array_key_exists($moduleKey, $modules)) {
            return redirect()->route('reports.index')->with('error', 'Invalid module selected.');
        }

        $user = Auth::user();
        $period = $request->period ?? 'all';
        $selectedClassLevel = trim((string) $request->class_level);

        if ($moduleKey === 'centers_without_data') {
            abort_if($user->role !== 'admin', 403);

            $records = $this->getCentersWithoutDataRecords();
            $moduleTitle = $modules[$moduleKey]['title'];

            return view('reports.index', compact(
                'modules',
                'user',
                'records',
                'moduleTitle',
                'period',
                'examClassLevelOptions',
                'selectedClassLevel'
            ))->with('isCentersWithoutDataReport', true);
        }

        // Admin anaweza kuchagua center yoyote, user wa kawaida anatumia center yake
        $centerId = $user->role === 'admin'
            ? strtoupper(trim((string) $request->center_id))
            : strtoupper((string) $user->center_id);

        if (!$centerId) {
            return redirect()->route('reports.index')->with('error', 'Center ID is required.');
        }

        $startDate = $this->resolveStartDate($period);

        $module = $modules[$moduleKey];
        $moduleTitle = $module['title'];
        $records = $this->buildRecordsQuery($module, $centerId);
        $table = $this->resolveModuleTable($module);

        if ($selectedClassLevel !== '' && array_key_exists($moduleKey, $examClassLevelOptions)) {
            $records->where('class_level', $selectedClassLevel);
        }

        // Apply date filter by available column
        if ($startDate) {
            if ($this->hasColumn($table, 'date')) {
                $records->whereDate('date', '>=', $startDate->toDateString());
            } elseif ($this->hasColumn($table, 'submitted_at')) {
                $records->whereDate('submitted_at', '>=', $startDate->toDateString());
            } else {
                $records->whereDate('created_at', '>=', $startDate->toDateString());
            }
        }

        // Apply sorting by available column
        if ($this->hasColumn($table, 'date')) {
            $records->orderByDesc('date');
        } elseif ($this->hasColumn($table, 'submitted_at')) {
            $records->orderByDesc('submitted_at');
        } else {
            $records->orderByDesc('created_at');
        }

        $records = $records->get();

        return view('reports.index', compact(
            'modules',
            'user',
            'records',
            'moduleTitle',
            'centerId',
            'period',
            'examClassLevelOptions',
            'selectedClassLevel'
        ));
    }

    /**
     * Print selected report.
     */
    public function print(Request $request): View|RedirectResponse
    {
        $request->validate([
            'module' => ['required', 'string'],
            'center_id' => ['nullable', 'string'],
            'period' => ['nullable', 'in:all,week,month,3months,6months'],
            'class_level' => ['nullable', 'string'],
        ]);

        $modules = $this->getModules();
        $moduleKey = $request->module;

        if (!array_key_exists($moduleKey, $modules)) {
            return redirect()->route('reports.index')->with('error', 'Invalid module selected.');
        }

        $user = Auth::user();
        $period = $request->period ?? 'all';
        $selectedClassLevel = trim((string) $request->class_level);

        if ($moduleKey === 'centers_without_data') {
            abort_if($user->role !== 'admin', 403);

            $records = $this->getCentersWithoutDataRecords();
            $moduleTitle = $modules[$moduleKey]['title'];

            return view('reports.print', compact(
                'records',
                'moduleTitle',
                'period',
                'selectedClassLevel'
            ))->with('isCentersWithoutDataReport', true);
        }

        $centerId = $user->role === 'admin'
            ? strtoupper(trim((string) $request->center_id))
            : strtoupper((string) $user->center_id);

        if (!$centerId) {
            return redirect()->route('reports.index')->with('error', 'Center ID is required.');
        }

        $startDate = $this->resolveStartDate($period);

        $module = $modules[$moduleKey];
        $moduleTitle = $module['title'];
        $records = $this->buildRecordsQuery($module, $centerId);
        $table = $this->resolveModuleTable($module);

        if ($selectedClassLevel !== '' && array_key_exists($moduleKey, $this->getExamClassLevelOptions())) {
            $records->where('class_level', $selectedClassLevel);
        }

        if ($startDate) {
            if ($this->hasColumn($table, 'date')) {
                $records->whereDate('date', '>=', $startDate->toDateString());
            } elseif ($this->hasColumn($table, 'submitted_at')) {
                $records->whereDate('submitted_at', '>=', $startDate->toDateString());
            } else {
                $records->whereDate('created_at', '>=', $startDate->toDateString());
            }
        }

        if ($this->hasColumn($table, 'date')) {
            $records->orderByDesc('date');
        } elseif ($this->hasColumn($table, 'submitted_at')) {
            $records->orderByDesc('submitted_at');
        } else {
            $records->orderByDesc('created_at');
        }

        $records = $records->get();

        return view('reports.print', compact(
            'records',
            'moduleTitle',
            'centerId',
            'period',
            'selectedClassLevel'
        ));
    }

    /**
     * Export selected report as a CSV file that opens in Excel.
     */
    public function export(Request $request): StreamedResponse|RedirectResponse
    {
        $request->validate([
            'module' => ['required', 'string'],
            'center_id' => ['nullable', 'string'],
            'period' => ['nullable', 'in:all,week,month,3months,6months'],
            'class_level' => ['nullable', 'string'],
        ]);

        $modules = $this->getModules();
        $moduleKey = $request->module;

        if (! array_key_exists($moduleKey, $modules)) {
            return redirect()->route('reports.index')->with('error', 'Invalid module selected.');
        }

        $user = Auth::user();
        $period = $request->period ?? 'all';
        $selectedClassLevel = trim((string) $request->class_level);

        if ($moduleKey === 'centers_without_data') {
            abort_if($user->role !== 'admin', 403);

            $records = $this->getCentersWithoutDataRecords();
            $filename = 'centers-without-data-'.now()->format('Ymd-His').'.csv';

            return $this->streamCsv($filename, function ($handle) use ($records) {
                fputcsv($handle, ['No.', 'Center ID', 'Total Users', 'First Registered', 'Status']);

                foreach ($records as $index => $record) {
                    fputcsv($handle, [
                        $index + 1,
                        strtoupper((string) $record->center_id),
                        $record->total_users,
                        $record->first_registered_at ? Carbon::parse($record->first_registered_at)->format('Y-m-d') : '',
                        'No data submitted',
                    ]);
                }
            });
        }

        $centerId = $user->role === 'admin'
            ? strtoupper(trim((string) $request->center_id))
            : strtoupper((string) $user->center_id);

        if (! $centerId) {
            return redirect()->route('reports.index')->with('error', 'Center ID is required.');
        }

        $module = $modules[$moduleKey];
        $records = $this->buildRecordsQuery($module, $centerId);
        $table = $this->resolveModuleTable($module);
        $startDate = $this->resolveStartDate($period);

        if ($selectedClassLevel !== '' && array_key_exists($moduleKey, $this->getExamClassLevelOptions())) {
            $records->where('class_level', $selectedClassLevel);
        }

        if ($startDate) {
            if ($this->hasColumn($table, 'date')) {
                $records->whereDate('date', '>=', $startDate->toDateString());
            } elseif ($this->hasColumn($table, 'submitted_at')) {
                $records->whereDate('submitted_at', '>=', $startDate->toDateString());
            } else {
                $records->whereDate('created_at', '>=', $startDate->toDateString());
            }
        }

        if ($this->hasColumn($table, 'date')) {
            $records->orderByDesc('date');
        } elseif ($this->hasColumn($table, 'submitted_at')) {
            $records->orderByDesc('submitted_at');
        } else {
            $records->orderByDesc('created_at');
        }

        $records = $records->get();
        $fields = $module['fields'] ?? [];
        $filename = str($module['title'] ?? 'report')
            ->slug()
            ->append('-'.$centerId.'-'.now()->format('Ymd-His').'.csv')
            ->toString();

        return $this->streamCsv($filename, function ($handle) use ($records, $fields) {
            fputcsv($handle, array_merge(['No.', 'Submitted By', 'Email', 'Center ID'], array_values($fields)));

            foreach ($records as $index => $record) {
                $row = [
                    $index + 1,
                    $record->user->center_id ?? 'Legacy record',
                    $record->user->email ?? '',
                    strtoupper((string) ($record->user->center_id ?? '')),
                ];

                foreach (array_keys($fields) as $field) {
                    $row[] = $this->exportValue($record, $field);
                }

                fputcsv($handle, $row);
            }
        });
    }

    /**
     * Resolve selected period to start date.
     */
    private function resolveStartDate(string $period): ?Carbon
    {
        return match ($period) {
            'week' => now()->subWeek(),
            'month' => now()->subMonth(),
            '3months' => now()->subMonths(3),
            '6months' => now()->subMonths(6),
            default => null,
        };
    }

    /**
     * Check whether a table contains a column.
     */
    private function hasColumn(string $table, string $column): bool
    {
        return Schema::hasColumn($table, $column);
    }

    private function buildRecordsQuery(array $module, string $centerId)
    {
        if (($module['source'] ?? null) === 'submissions') {
            return Submission::with('user')
                ->where('section_type', $module['section_type'])
                ->whereHas('user', function ($query) use ($centerId) {
                    $query->whereRaw('UPPER(center_id) = ?', [$centerId]);
                });
        }

        $modelClass = $module['model'];
        $query = $modelClass::with('user')
            ->whereHas('user', function ($query) use ($centerId) {
                $query->whereRaw('UPPER(center_id) = ?', [$centerId]);
            });

        foreach (($module['where'] ?? []) as $column => $value) {
            $query->where($column, $value);
        }

        return $query;
    }

    private function resolveModuleTable(array $module): string
    {
        if (($module['source'] ?? null) === 'submissions') {
            return (new Submission())->getTable();
        }

        return (new $module['model'])->getTable();
    }

    /**
     * Available report modules.
     */
    private function getModules(): array
    {
        $modules = config('reports.modules', []);

        if (! config('features.local_sponsorship_visible')) {
            unset($modules['local_sponsorship']);
        }

        return array_merge($modules, [
            'centers_without_data' => [
                'title' => 'Centers Without Data',
            ],
        ]);
    }

    private function getCentersWithoutDataRecords()
    {
        $models = [
            ParentsInformation::class,
            BaseLeader::class,
            MasomoYaMtaala::class,
            HomeVisitation::class,
            SchoolVisitation::class,
            Submission::class,
            CenterLeadership::class,
            TalentsInformation::class,
            SkillsInformation::class,
            SkillsAttendance::class,
            CurriculumAttendance::class,
            TalentAttendance::class,
            SpecialProgram::class,
            SchoolInformationRecord::class,
            ExamResult::class,
        ];

        if (config('features.local_sponsorship_visible')) {
            $models[] = LocalSponsorship::class;
        }

        $userIdsWithData = collect();

        foreach ($models as $modelClass) {
            $userIdsWithData = $userIdsWithData->merge(
                $modelClass::query()
                    ->whereNotNull('user_id')
                    ->distinct()
                    ->pluck('user_id')
            );
        }

        $userIdsWithData = $userIdsWithData->filter()->unique()->values();

        $centersWithData = User::query()
            ->whereIn('id', $userIdsWithData)
            ->whereNotNull('center_id')
            ->where('center_id', '!=', '')
            ->selectRaw('UPPER(center_id) as center_key')
            ->distinct()
            ->pluck('center_key');

        return User::query()
            ->where('role', 'user')
            ->whereNotNull('center_id')
            ->where('center_id', '!=', '')
            ->when($centersWithData->isNotEmpty(), function ($query) use ($centersWithData) {
                $query->whereNotIn(DB::raw('UPPER(center_id)'), $centersWithData->all());
            })
            ->selectRaw('UPPER(center_id) as center_key, MIN(center_id) as center_id, COUNT(*) as total_users, MIN(created_at) as first_registered_at')
            ->groupBy('center_key')
            ->orderBy('center_key')
            ->get();
    }

    private function getExamClassLevelOptions(): array
    {
        return [
            'exam_primary' => [
                'Grade 1',
                'Grade 2',
                'Grade 3',
                'Grade 4',
                'Grade 5',
                'Grade 6',
                'Grade 7',
            ],
            'exam_secondary' => [
                'Form 1',
                'Form 2',
                'Form 3',
                'Form 4',
            ],
            'exam_a_level' => [
                'Form 5',
                'Form 6',
            ],
        ];
    }

    private function streamCsv(string $filename, callable $writer): StreamedResponse
    {
        return response()->streamDownload(function () use ($writer) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            $writer($handle);
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function exportValue($record, string $field): string
    {
        $value = data_get($record, $field);

        if ($value === null && is_array($record->form_data ?? null)) {
            $value = data_get($record->form_data, $field);
        }

        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d H:i:s');
        }

        if (is_bool($value)) {
            return $value ? 'Yes' : 'No';
        }

        if (is_array($value)) {
            return collect($value)->flatten()->filter()->implode(' | ');
        }

        return trim((string) $value);
    }
}
