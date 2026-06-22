<?php

namespace App\Http\Controllers;

use App\Mail\CenterDataReportMail;
use App\Models\User;
use App\Models\Participant;
use App\Models\Instructor;
use App\Models\Program;
use App\Models\Session;
use App\Models\Venue;
use App\Models\Skill;
use App\Models\SkillVideo;
use App\Models\TalentAttendance;
use App\Models\TalentsInformation;
use App\Models\ParentsInformation;
use App\Models\BaseLeader;
use App\Models\SpecialProgram;
use App\Models\MasomoYaMtaala;
use App\Models\MasomoYaFani;
use App\Models\CurriculumAttendance;
use App\Models\SkillsAttendance;
use App\Models\SkillsInformation;
use App\Models\Submission;
use App\Models\CenterLeadership;
use App\Models\HomeVisitation;
use App\Models\SchoolVisitation;
use App\Models\LocalSponsorship;
use App\Models\ClusterLeader;
use App\Models\OutOfMinistryLeader;
use App\Models\SchoolInformationRecord;
use App\Models\ExamResult;
use App\Models\FormTwoAssessment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Throwable;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only(['admin', 'updateUser', 'deleteUser', 'toggleUserStatus', 'showCenterProfile', 'centersWithoutData', 'sendCenterDataReports']);
    }

    /**
     * Display the user dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        // Redirect admin users to admin dashboard
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // User-specific statistics (limited view)
        $stats = [
            'my_attendance' => $this->scopeRecordsVisibleToUser(TalentAttendance::query(), $user)->count(),
            'total_programs' => Program::count(),
            'available_skills' => SkillVideo::where('is_active', true)->count(),
        ];

        // User's recent activities only
        $myRecentAttendance = $this->scopeRecordsVisibleToUser(TalentAttendance::query(), $user)
            ->latest()
            ->take(5)
            ->get();

        // Latest active skill videos for dashboard preview
        $skillVideos = SkillVideo::where('is_active', true)
            ->latest()
            ->take(3)
            ->get();

        $centerId = strtoupper(trim((string) $user->center_id));
        $centerDataSummary = collect();
        $totalCenterDataRecords = 0;
        $publishedResultsCount = FormTwoAssessment::where('is_published', true)->count();

        if ($centerId !== '') {
            $centerDataSummary = $this->getCenterDataSummary($centerId);
            $totalCenterDataRecords = $centerDataSummary->sum('count');
        }

        return view('dashboard.user', compact(
            'stats',
            'myRecentAttendance',
            'skillVideos',
            'centerId',
            'centerDataSummary',
            'totalCenterDataRecords',
            'publishedResultsCount'
        ));
    }

    /**
     * Display the admin dashboard.
     */
    public function admin()
    {
        // Get comprehensive statistics for admin
        $centersWithoutData = $this->getCentersWithoutData();

        $stats = [
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'regular_users' => User::where('role', 'user')->count(),
            'pending_users' => User::where('status', 'pending')->orWhereNull('status')->count(),
            'approved_users' => User::where('status', 'approved')->count(),
            'rejected_users' => User::where('status', 'rejected')->count(),
            'active_users' => User::where('created_at', '>=', now()->subDays(30))->count(),
            'recent_users' => User::where('created_at', '>=', now()->subDays(7))->count(),
            'inactive_users' => User::where('created_at', '<', now()->subDays(30))->count(),
            'total_participants' => Participant::count(),
            'total_instructors' => Instructor::count(),
            'total_programs' => Program::count(),
            'total_sessions' => Session::count(),
            'total_venues' => Venue::count(),
            'total_skills' => Skill::count(),
            'total_attendance' => TalentAttendance::count(),
            'total_talents' => TalentsInformation::count(),
            'recent_talents' => TalentsInformation::where('created_at', '>=', now()->subDays(7))->count(),
            'talents_needing_training' => TalentsInformation::where('needs_training', true)->count(),
            'talents_with_competitions' => TalentsInformation::where('has_competed', true)->count(),
            'total_submissions' => $this->getTotalSubmissionsCount(),
            'total_center_leadership' => CenterLeadership::count(),
            'total_center_leadership_submissions' => CenterLeadership::count(),
            'centers_without_data' => $centersWithoutData->count(),
        ];

        // Get user registration trends (last 6 months)
        $userRegistrationTrends = User::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Get role distribution
        $roleDistribution = User::select('role', DB::raw('COUNT(*) as count'))
            ->groupBy('role')
            ->get();

        // Get monthly attendance data for chart
        $monthlyAttendance = TalentAttendance::select(
            DB::raw('MONTH(date) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Get recent system activities
        $recentUsers = User::latest()->take(5)->get();
        $recentParticipants = Participant::latest()->take(5)->get();

        // Get all users for management
        $allUsers = User::with(['talentAttendance'])
            ->withCount('talentAttendance')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get users needing attention
        $usersNeedingAttention = User::where(function ($query) {
            $query->whereDoesntHave('talentAttendance')
                ->orWhere('created_at', '>', now()->subDays(7));
        })->take(5)->get();

        // Get recent user submissions for review
        $recentSubmissions = $this->getRecentSubmissions();

        // Get recent users
        $recentNewUsers = User::orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Get pending users for approval
        $pendingUsers = User::where('status', 'pending')
            ->orWhereNull('status')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $centerReportRecipientCount = User::where('role', '!=', 'admin')
            ->whereNotNull('email')
            ->whereNotNull('center_id')
            ->whereRaw("TRIM(email) <> ''")
            ->whereRaw("TRIM(center_id) <> ''")
            ->count();

        $centerReportCenterCount = User::where('role', '!=', 'admin')
            ->whereNotNull('email')
            ->whereNotNull('center_id')
            ->whereRaw("TRIM(email) <> ''")
            ->whereRaw("TRIM(center_id) <> ''")
            ->selectRaw('UPPER(TRIM(center_id)) as normalized_center_id')
            ->distinct()
            ->get()
            ->count();

        return view('dashboard.admin', compact(
            'stats',
            'userRegistrationTrends',
            'roleDistribution',
            'monthlyAttendance',
            'recentUsers',
            'recentParticipants',
            'allUsers',
            'usersNeedingAttention',
            'recentSubmissions',
            'recentNewUsers',
            'pendingUsers',
            'centersWithoutData',
            'centerReportRecipientCount',
            'centerReportCenterCount'
        ));
    }

    public function sendCenterDataReports(Request $request)
    {
        $validated = $request->validate([
            'caption' => ['required', 'string', 'max:1500'],
            'delivery_mode' => ['nullable', 'in:individual,grouped_center'],
        ]);

        $deliveryMode = $validated['delivery_mode'] ?? 'individual';

        $users = User::where('role', '!=', 'admin')
            ->orderBy('id')
            ->get();

        $summaryByCenter = [];
        $centerUserCounts = $users
            ->filter(fn (User $user) => trim((string) $user->center_id) !== '')
            ->countBy(fn (User $user) => strtoupper(trim((string) $user->center_id)));
        $sent = 0;
        $failed = 0;
        $skipped = 0;

        $validUsers = $users->filter(function (User $user) use (&$skipped) {
            $email = trim((string) $user->email);
            $centerId = strtoupper(trim((string) $user->center_id));

            if ($email === '' || $centerId === '') {
                $skipped++;
                return false;
            }

            return true;
        });

        if ($deliveryMode === 'grouped_center') {
            $primaryAdmin = trim((string) config('center_data_reports.primary_admin_email'));
            $secondaryAdmin = trim((string) config('center_data_reports.secondary_admin_email'));

            foreach ($validUsers->groupBy(fn (User $user) => strtoupper(trim((string) $user->center_id))) as $centerId => $centerUsers) {
                if (! isset($summaryByCenter[$centerId])) {
                    $summaryByCenter[$centerId] = $this->getCenterDataSummary($centerId)->all();
                }

                $summary = $summaryByCenter[$centerId];
                $totalRecords = (int) collect($summary)->sum('count');
                $toEmails = collect([$primaryAdmin, $secondaryAdmin])
                    ->merge($centerUsers->pluck('email')->map(fn ($email) => trim((string) $email)))
                    ->filter()
                    ->unique(fn ($email) => strtolower($email))
                    ->values()
                    ->all();

                try {
                    Mail::to($toEmails)->send(new CenterDataReportMail(
                            recipient: $centerUsers->first(),
                            caption: $validated['caption'],
                            centerId: $centerId,
                            summary: $summary,
                            totalRecords: $totalRecords,
                            centerUsersCount: $centerUsers->count(),
                    ));
                    $sent++;
                } catch (Throwable $exception) {
                    $failed++;
                    Log::error('Grouped center data report email failed.', [
                        'center_id' => $centerId,
                        'error' => $exception->getMessage(),
                    ]);
                }
            }

            $message = "Report email zimetumwa kwa Center ID {$sent}.";
        } else {
            foreach ($validUsers as $user) {
                $email = trim((string) $user->email);
                $centerId = strtoupper(trim((string) $user->center_id));

                if (! isset($summaryByCenter[$centerId])) {
                    $summaryByCenter[$centerId] = $this->getCenterDataSummary($centerId)->all();
                }

                $summary = $summaryByCenter[$centerId];
                $totalRecords = (int) collect($summary)->sum('count');

                try {
                    Mail::to($email)->send(new CenterDataReportMail(
                        recipient: $user,
                        caption: $validated['caption'],
                        centerId: $centerId,
                        summary: $summary,
                        totalRecords: $totalRecords,
                        centerUsersCount: (int) ($centerUserCounts[$centerId] ?? 1),
                    ));
                    $sent++;
                } catch (Throwable $exception) {
                    $failed++;
                    Log::error('Center data report email failed.', [
                        'user_id' => $user->id,
                        'center_id' => $centerId,
                        'error' => $exception->getMessage(),
                    ]);
                }
            }

            $message = "Report email zimetumwa kwa users {$sent}.";
        }

        if ($skipped > 0) {
            $message .= " Users {$skipped} wamerukwa kwa kukosa email au Center ID.";
        }

        if ($failed > 0) {
            return back()->withInput()->with('error', $message." Email {$failed} zimeshindwa kutumwa; angalia mail settings/logs.");
        }

        return back()->with('success', $message);
    }

    /**
     * Get count of total submissions across all models
     */
    private function getTotalSubmissionsCount()
    {
        $count = 0;

        $count += ParentsInformation::count();
        $count += BaseLeader::count();
        $count += MasomoYaMtaala::count();
        $count += HomeVisitation::count();
        $count += SchoolVisitation::count();
        $count += Submission::count();

        return $count;
    }

    /**
     * Get recent submissions from various models for admin review
     */
    private function getRecentSubmissions()
    {
        $parentsInfo = ParentsInformation::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Parents Information',
                    'title' => $item->parent_name . ' - ' . $item->parent_of,
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at,
                    'route' => 'parents-information.show',
                    'url' => route('parents-information.show', $item->id),
                    'id' => $item->id,
                    'icon' => 'bi-people',
                    'color' => 'primary',
                    'status' => 'submitted',
                ];
            });

        $baseLeaders = BaseLeader::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Base Leader',
                    'title' => $item->leader_name . ' - ' . $item->position,
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at,
                    'route' => 'base-leaders.show',
                    'id' => $item->id,
                    'icon' => 'bi-person-badge',
                    'color' => 'success',
                    'status' => 'submitted',
                ];
            });

        $specialPrograms = SpecialProgram::with('user')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Special Program',
                    'title' => $item->topic . ' by ' . $item->teacher,
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at,
                    'route' => 'submissions.special-program.show',
                    'id' => $item->id,
                    'icon' => 'bi-star',
                    'color' => 'warning',
                    'status' => 'submitted',
                ];
            });

        $masomoYaMtaala = MasomoYaMtaala::with('user')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Curriculum Lesson',
                    'title' => $item->topic ?? $item->mada_aliyo_fundisha ?? '-',
                    'user' => $item->user->center_id ?? $item->user->name ?? 'Unknown',
                    'date' => $item->created_at,
                    'route' => auth()->user()->role === 'admin'
                        ? 'admin.masomo-ya-mtaala.show'
                        : 'submissions.masomo-ya-mtaala.show',
                    'id' => $item->id,
                    'icon' => 'bi-book',
                    'color' => 'info',
                    'status' => 'submitted',
                ];
            });

        $curriculumAttendance = CurriculumAttendance::with('user')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Curriculum Attendance',
                    'title' => $item->somo . ' by ' . $item->jina_la_mwalimu,
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at,
                    'route' => 'curriculum-attendance.show',
                    'id' => $item->id,
                    'icon' => 'bi-calendar-check',
                    'color' => 'secondary',
                    'status' => 'submitted',
                ];
            });

        $skillsAttendance = SkillsAttendance::with('user')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Skills Attendance',
                    'title' => 'Skills session on ' . $item->date->format('M d, Y'),
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at,
                    'route' => 'skills-attendance.show',
                    'id' => $item->id,
                    'icon' => 'bi-tools',
                    'color' => 'danger',
                    'status' => 'submitted',
                ];
            });

        $homeVisitations = HomeVisitation::with('user')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Home Visitation',
                    'title' => 'Visit to ' . $item->participant_name . ' on ' . $item->visit_date,
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at,
                    'route' => 'home-visitation.show',
                    'id' => $item->id,
                    'icon' => 'bi-house-door',
                    'color' => 'primary',
                    'status' => 'submitted',
                ];
            });

        $schoolVisitations = SchoolVisitation::with('user')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'School Visitation',
                    'title' => $item->participant_name . ' - ' . $item->school_name,
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at,
                    'route' => 'school-visitation.show',
                    'id' => $item->id,
                    'icon' => 'bi-building-check',
                    'color' => 'info',
                    'status' => 'submitted',
                ];
            });

        $centerLeadership = CenterLeadership::with('user')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Center Leadership',
                    'title' => $item->center_name . ' Leadership Info',
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at,
                    'route' => 'center-leadership.show',
                    'id' => $item->id,
                    'icon' => 'bi-geo-alt',
                    'color' => 'success',
                    'status' => 'submitted',
                ];
            });

        $talentSubmissions = TalentsInformation::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Talent Information',
                    'title' => $item->student_name . ' - ' . $item->talent_type,
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at,
                    'route' => 'talents.show',
                    'id' => $item->id,
                    'icon' => 'bi-star-fill',
                    'color' => 'warning',
                    'status' => 'submitted',
                ];
            });

        $skillsInformation = SkillsInformation::with('user')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Skills Information',
                    'title' => $item->student_name . ' - ' . $item->skill_category,
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at ?? $item->updated_at ?? now(),
                    'route' => 'skills-information.show',
                    'id' => $item->id,
                    'icon' => 'bi-tools',
                    'color' => 'info',
                    'status' => 'submitted',
                ];
            });

        $programDaySubmissions = Submission::with('user')
            ->whereNotIn('section_type', [
                'exam_primary',
                'exam_secondary',
                'exam_a_level',
                'exam_college',
                'exam_university',
                'school_primary',
                'school_secondary',
                'school_a_level',
                'school_university',
                'school_college',
                'school_vocational_training',
                'school_others',
            ])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                $sectionTitles = [
                    'school_primary' => 'Primary School Info',
                    'school_secondary' => 'Secondary School Info',
                    'school_a_level' => 'A-Level School Info',
                    'school_university' => 'University Info',
                    'school_college' => 'College Info',
                    'school_vocational_training' => 'Vocational Training Info',
                    'school_others' => 'Other School Info',
                    'masomo_ya_mtaala' => 'Curriculum Lesson',
                    'fani' => 'Subject Information',
                    'special_program' => 'Special Program',
                    'parents' => 'Parents Information',
                    'vikoba' => 'Savings Group Info',
                ];

                return [
                    'type' => $sectionTitles[$item->section_type] ?? ucwords(str_replace('_', ' ', $item->section_type)),
                    'title' => $sectionTitles[$item->section_type] ?? 'Program Day Submission',
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at,
                    'route' => 'admin.submissions.show',
                    'id' => $item->id,
                    'icon' => $this->getSubmissionIcon($item->section_type),
                    'color' => $this->getSubmissionColor($item->section_type),
                    'status' => 'submitted',
                ];
            });

        $allCollections = collect([
            $parentsInfo,
            $baseLeaders,
            $specialPrograms,
            $masomoYaMtaala,
            $curriculumAttendance,
            $skillsAttendance,
            $skillsInformation,
            $homeVisitations,
            $schoolVisitations,
            $centerLeadership,
            $talentSubmissions,
            $programDaySubmissions,
        ]);

        $submissions = collect();

        foreach ($allCollections as $collection) {
            if ($collection && $collection->count() > 0) {
                $submissions = $submissions->merge($collection);
            }
        }

        return $submissions
            ->sortByDesc('date')
            ->values()
            ->take(12);
    }

    private function getSubmissionIcon($sectionType)
    {
        $icons = [
            'school_primary' => 'bi-mortarboard',
            'school_secondary' => 'bi-book',
            'school_a_level' => 'bi-bank',
            'school_university' => 'bi-mortarboard-fill',
            'school_college' => 'bi-award',
            'school_vocational_training' => 'bi-tools',
            'school_others' => 'bi-three-dots',
            'masomo_ya_mtaala' => 'bi-book',
            'fani' => 'bi-journal-text',
            'special_program' => 'bi-star',
            'parents' => 'bi-people',
            'vikoba' => 'bi-piggy-bank',
        ];

        return $icons[$sectionType] ?? 'bi-folder';
    }

    private function getSubmissionColor($sectionType)
    {
        $colors = [
            'school_primary' => 'primary',
            'school_secondary' => 'info',
            'school_a_level' => 'warning',
            'school_university' => 'success',
            'school_college' => 'danger',
            'school_vocational_training' => 'secondary',
            'school_others' => 'dark',
            'masomo_ya_mtaala' => 'info',
            'fani' => 'warning',
            'special_program' => 'success',
            'parents' => 'primary',
            'vikoba' => 'secondary',
        ];

        return $colors[$sectionType] ?? 'dark';
    }

    private function getCentersWithoutData()
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
            ->selectRaw('UPPER(center_id) as center_key, MIN(center_id) as center_id, COUNT(*) as total_users, MIN(created_at) as first_registered_at')
            ->when($centersWithData->isNotEmpty(), function ($query) use ($centersWithData) {
                $query->whereNotIn(DB::raw('UPPER(center_id)'), $centersWithData->all());
            })
            ->groupBy('center_key')
            ->orderBy('center_key')
            ->get();
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'center_id' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $user->update([
            'center_id' => $request->center_id,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'User updated successfully!');
    }

    public function toggleUserStatus(User $user)
    {
        $user->update([
            'status' => $user->status === 'approved' ? 'rejected' : 'approved',
        ]);

        return redirect()->back()->with('success', 'User status updated successfully!');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }

    public function manageUsers()
    {
        $users = User::with('approvedBy')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function showCenterProfile(Request $request, User $user)
    {
        $centerId = strtoupper(trim((string) $user->center_id));

        if ($centerId === '') {
            return redirect()->back()->with('error', 'User huyu hana Center ID ya kufungulia profile ya kituo.');
        }

        $modules = $this->getCenterProfileModules();
        $period = $request->get('period', 'all');
        $startDate = $this->resolveCenterProfileStartDate($period);
        $moduleCounts = [];

        foreach ($modules as $moduleKey => $module) {
            $moduleCounts[$moduleKey] = $this->applyCenterProfilePeriod(
                $this->buildCenterModuleQuery($module, $centerId),
                $module,
                $startDate
            )->count();
        }

        $selectedModule = $request->get('module');

        if (! $selectedModule || ! array_key_exists($selectedModule, $modules)) {
            $selectedModule = collect($moduleCounts)
                ->filter(fn ($count) => $count > 0)
                ->keys()
                ->first() ?? array_key_first($modules);
        }

        $selectedModuleConfig = $modules[$selectedModule];
        $records = $this->applyCenterProfilePeriod(
            $this->buildCenterModuleQuery($selectedModuleConfig, $centerId),
            $selectedModuleConfig,
            $startDate
        );

        $records = $this->applyCenterProfileSort($records, $selectedModuleConfig)->paginate(12)->withQueryString();

        $centerUsers = User::whereRaw('UPPER(center_id) = ?', [$centerId])
            ->orderByRaw("CASE WHEN role = 'admin' THEN 0 ELSE 1 END")
            ->orderBy('email')
            ->get();

        $periodLabels = [
            'all' => 'All Time',
            'week' => 'Last 1 Week',
            'month' => 'Last 1 Month',
            '3months' => 'Last 3 Months',
            '6months' => 'Last 6 Months',
        ];

        return view('admin.center-profile', [
            'selectedUser' => $user,
            'centerId' => $centerId,
            'centerUsers' => $centerUsers,
            'modules' => $modules,
            'moduleCounts' => $moduleCounts,
            'selectedModule' => $selectedModule,
            'selectedModuleConfig' => $selectedModuleConfig,
            'records' => $records,
            'period' => $period,
            'periodLabels' => $periodLabels,
            'totalCenterRecords' => array_sum($moduleCounts),
        ]);
    }

    public function centersWithoutData()
    {
        $centersWithoutData = $this->getCentersWithoutData();

        return view('admin.centers-without-data', [
            'centersWithoutData' => $centersWithoutData,
            'totalCentersWithoutData' => $centersWithoutData->count(),
        ]);
    }

    public function approveUser(User $user)
    {
        $user->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'User approved successfully!');
    }

    public function rejectUser(User $user)
    {
        $user->update([
            'status' => 'rejected',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'User rejected successfully!');
    }

    public function adminSearch(Request $request)
    {
        $query = $request->get('q', '');
        $results = [];

        if ($query) {
            $results = $this->searchAllSubmissions($query);
        }

        return view('admin.search', compact('results', 'query'));
    }

    public function adminSearchAjax(Request $request)
    {
        $query = $request->get('q', '');
        $results = [];

        if ($query) {
            $results = $this->searchAllSubmissions($query);
        }

        return response()->json([
            'success' => true,
            'results' => $results,
            'count' => count($results),
        ]);
    }

    public function userSearch(Request $request)
    {
        $query = $request->get('q', '');
        $results = [];

        if ($query) {
            $results = $this->searchUserSubmissions($query);
        }

        return view('user.search', compact('results', 'query'));
    }

    public function userSearchAjax(Request $request)
    {
        $query = $request->get('q', '');
        $results = [];

        if ($query) {
            $results = $this->searchUserSubmissions($query);
        }

        return response()->json([
            'success' => true,
            'results' => $results,
            'count' => count($results),
        ]);
    }

    private function searchAllSubmissions($query)
    {
        return $this->runSubmissionSearch($query);
    }

    private function searchUserSubmissions($query)
    {
        return $this->runSubmissionSearch($query, auth()->user());
    }

    private function runSubmissionSearch(string $query, ?User $scopedUser = null): array
    {
        $searchTerm = trim($query);
        $viewer = auth()->user();
        $isAdminViewer = $viewer && method_exists($viewer, 'isAdmin') ? $viewer->isAdmin() : (($viewer->role ?? null) === 'admin');

        if ($searchTerm === '') {
            return [];
        }

        $sources = [
            [
                'model' => ParentsInformation::class,
                'type' => 'Parents Information',
                'fields' => ['parent_name', 'parent_of', 'activity', 'support_type', 'address', 'parent_comments'],
                'title' => fn ($item) => trim(($item->parent_name ?? 'Parent') . ' - ' . ($item->parent_of ?? 'Record')),
                'description' => fn ($item) => $item->activity ?? $item->support_type ?? 'Parent information record',
                'location' => 'Parents Information',
                'url' => fn ($item) => route('parents-information.show', $item),
            ],
            [
                'model' => CenterLeadership::class,
                'type' => 'Center Leadership',
                'fields' => ['center_name', 'challenges', 'feedback'],
                'title' => fn ($item) => trim(($item->center_name ?? 'Center') . ' Leadership'),
                'description' => fn ($item) => $item->feedback ?? $item->challenges ?? 'Leadership record',
                'location' => 'Center Leadership',
                'url' => fn ($item) => route('center-leadership.show', $item),
            ],
            [
                'model' => SpecialProgram::class,
                'type' => 'Special Program',
                'fields' => ['topic', 'teacher', 'age_range', 'teacher_feedback', 'supervisor_feedback'],
                'title' => fn ($item) => trim(($item->topic ?? 'Special Program') . ' by ' . ($item->teacher ?? 'Unknown')),
                'description' => fn ($item) => $item->teacher_feedback ?? $item->supervisor_feedback ?? 'Special program record',
                'location' => 'Program Day > Special Program',
                'url' => fn ($item) => route('submissions.special-program.show', $item),
            ],
            [
                'model' => HomeVisitation::class,
                'type' => 'Home Visitation',
                'fields' => ['jina', 'namba', 'shule', 'mtaa', 'participant_comments', 'changamoto', 'mapendekezo'],
                'title' => fn ($item) => trim(($item->jina ?? 'Participant') . ' - Home Visit'),
                'description' => fn ($item) => $item->mtaa ?? $item->participant_comments ?? 'Home visitation record',
                'location' => 'Home Visitation',
                'url' => fn ($item) => route('home-visitation.show', $item),
            ],
            [
                'model' => SchoolVisitation::class,
                'type' => 'School Visitation',
                'fields' => ['participant_name', 'registration_number', 'school_name', 'class_level', 'teacher_comments', 'visitor_comments'],
                'title' => fn ($item) => trim(($item->participant_name ?? 'Participant') . ' - ' . ($item->school_name ?? 'School')),
                'description' => fn ($item) => $item->teacher_comments ?? $item->visitor_comments ?? 'School visitation record',
                'location' => 'School Visitation',
                'url' => fn ($item) => route('school-visitation.show', $item),
            ],
            [
                'model' => TalentsInformation::class,
                'type' => 'Talents Information',
                'fields' => ['student_name', 'participant_number', 'talent_type', 'talent_description', 'achievements', 'comments'],
                'title' => fn ($item) => trim(($item->student_name ?? 'Student') . ' - ' . ($item->talent_type ?? 'Talent')),
                'description' => fn ($item) => $item->talent_description ?? $item->comments ?? 'Talent information record',
                'location' => 'Talents Information',
                'url' => fn ($item) => route('talents.show', $item),
            ],
            [
                'model' => SkillsInformation::class,
                'type' => 'Skills Information',
                'fields' => ['student_name', 'student_id', 'skill_category', 'specific_skills', 'mentor', 'comments'],
                'title' => fn ($item) => trim(($item->student_name ?? 'Student') . ' - ' . ($item->skill_category ?? 'Skill')),
                'description' => fn ($item) => $item->specific_skills ?? $item->comments ?? 'Skills information record',
                'location' => 'Skills Information',
                'url' => fn ($item) => route('skills-information.show', $item),
            ],
            [
                'model' => TalentAttendance::class,
                'type' => 'Talent Attendance',
                'fields' => ['instructor_name', 'talent_taught', 'lesson_topic', 'instructor_comments', 'supervisor_comments'],
                'title' => fn ($item) => trim(($item->talent_taught ?? 'Talent Attendance') . ' - ' . ($item->instructor_name ?? 'Instructor')),
                'description' => fn ($item) => $item->lesson_topic ?? $item->instructor_comments ?? 'Talent attendance record',
                'location' => 'Talent Attendance',
                'url' => fn ($item) => route('talent-attendance.show', $item),
            ],
            [
                'model' => SkillsAttendance::class,
                'type' => 'Skills Attendance',
                'fields' => ['teacher_name', 'lesson_topic', 'teacher_comments', 'supervisor_comments'],
                'title' => fn ($item) => trim(('Skills Attendance') . ' - ' . ($item->teacher_name ?? 'Teacher')),
                'description' => fn ($item) => $item->lesson_topic ?? $item->teacher_comments ?? 'Skills attendance record',
                'location' => 'Skills Attendance',
                'url' => fn ($item) => route('skills-attendance.show', $item),
            ],
            [
                'model' => CurriculumAttendance::class,
                'type' => 'Curriculum Attendance',
                'fields' => ['jina_la_mwalimu', 'somo', 'mada', 'maoni_ya_mwalimu', 'maoni_ya_msimamizi'],
                'title' => fn ($item) => trim(($item->somo ?? 'Curriculum') . ' - ' . ($item->jina_la_mwalimu ?? 'Teacher')),
                'description' => fn ($item) => $item->mada ?? $item->maoni_ya_mwalimu ?? 'Curriculum attendance record',
                'location' => 'Curriculum Attendance',
                'url' => fn ($item) => route('curriculum-attendance.show', $item),
            ],
            [
                'model' => MasomoYaMtaala::class,
                'type' => 'Curriculum Studies',
                'fields' => ['jina_la_mwalimu', 'somo_analofundisha', 'mada_aliyo_fundisha', 'maoni_ya_mwanafunzi', 'maoni_ya_mwalimu'],
                'title' => fn ($item) => trim(($item->mada_aliyo_fundisha ?? 'Mtaala') . ' - ' . ($item->jina_la_mwalimu ?? 'Teacher')),
                'description' => fn ($item) => $item->somo_analofundisha ?? $item->maoni_ya_mwalimu ?? 'Masomo ya mtaala record',
                'location' => 'Program Day > Curriculum Studies',
                'url' => fn ($item) => route($isAdminViewer ? 'admin.masomo-ya-mtaala.show' : 'submissions.masomo-ya-mtaala.show', $item),
            ],
            [
                'model' => MasomoYaFani::class,
                'type' => 'Masomo ya Fani',
                'fields' => ['teacher_name', 'subject_name', 'topic_taught', 'student_comments', 'teacher_comments'],
                'title' => fn ($item) => trim(($item->topic_taught ?? 'Fani') . ' - ' . ($item->teacher_name ?? 'Teacher')),
                'description' => fn ($item) => $item->subject_name ?? $item->teacher_comments ?? 'Masomo ya fani record',
                'location' => 'Program Day > Masomo ya Fani',
                'url' => fn ($item) => route($isAdminViewer ? 'admin.masomo-ya-fani.show' : 'submissions.masomo-ya-fani.show', $item),
            ],
            [
                'model' => \App\Models\ExamResult::class,
                'type' => 'Exam Results',
                'fields' => ['student_name', 'school_name', 'class_level', 'exam_type', 'performance', 'best_subjects', 'failed_subjects', 'comments'],
                'title' => fn ($item) => trim(($item->student_name ?? 'Student') . ' - ' . ($item->exam_type ?? 'Exam')),
                'description' => fn ($item) => $item->school_name ?? $item->comments ?? 'Exam result record',
                'location' => fn ($item) => 'Exam Results > ' . ucwords((string) $item->education_level),
                'url' => fn ($item) => route('exam-results.' . $item->education_level . '.show', $item),
            ],
            [
                'model' => SchoolInformationRecord::class,
                'type' => 'School Information',
                'fields' => ['form_data'],
                'title' => fn ($item) => 'School Information - ' . ucwords((string) $item->education_level),
                'description' => fn ($item) => $this->extractSearchableFormDataSummary($item->form_data),
                'location' => fn ($item) => 'School Information > ' . ucwords((string) $item->education_level),
                'url' => fn ($item) => route('school-info.' . $item->education_level . '.show', $item),
            ],
            [
                'model' => BaseLeader::class,
                'type' => 'Base Leader',
                'fields' => ['leader_name', 'position', 'phone_number', 'comments'],
                'title' => fn ($item) => trim(($item->leader_name ?? 'Leader') . ' - ' . ($item->position ?? 'Position')),
                'description' => fn ($item) => $item->comments ?? $item->phone_number ?? 'Base leader record',
                'location' => 'Leadership Information > Base Leaders',
                'url' => fn ($item) => route('base-leaders.show', $item),
            ],
        ];

        if (config('features.local_sponsorship_visible')) {
            $sources[] = [
                'model' => LocalSponsorship::class,
                'type' => 'Local Sponsorship',
                'fields' => ['child_name', 'location_found', 'sponsor_name', 'sponsor_type', 'child_local_number'],
                'title' => fn ($item) => trim(($item->child_name ?? 'Child') . ' - ' . ($item->sponsor_name ?? 'Sponsor')),
                'description' => fn ($item) => $item->location_found ?? $item->sponsor_type ?? 'Local sponsorship record',
                'location' => 'Local Sponsorship',
                'url' => fn ($item) => route('local-sponsorship.show', $item),
            ];
        }

        $results = collect();

        foreach ($sources as $source) {
            $modelClass = $source['model'];
            $itemsQuery = $modelClass::query()->with('user');

            if ($scopedUser !== null) {
                $this->scopeRecordsVisibleToUser($itemsQuery, $scopedUser);
            }

            $items = $itemsQuery
                ->where(function ($builder) use ($source, $searchTerm) {
                    foreach ($source['fields'] as $index => $field) {
                        if ($index === 0) {
                            $builder->where($field, 'LIKE', "%{$searchTerm}%");
                        } else {
                            $builder->orWhere($field, 'LIKE', "%{$searchTerm}%");
                        }
                    }
                })
                ->latest()
                ->limit(8)
                ->get()
                ->map(function ($item) use ($source) {
                    $description = value($source['description'], $item);
                    $submittedBy = $item->user->center_id
                        ?? $item->user->email
                        ?? $item->user->name
                        ?? 'Legacy record';

                    return [
                        'type' => $source['type'],
                        'title' => value($source['title'], $item),
                        'description' => $description,
                        'user' => $item->user->center_id ?? 'No Center ID',
                        'submitted_by' => $submittedBy,
                        'date' => optional($item->created_at)->format('M d, Y') ?? 'N/A',
                        'sort_date' => optional($item->created_at)->timestamp ?? 0,
                        'status' => $item->status ?? 'submitted',
                        'id' => $item->id,
                        'location' => value($source['location'] ?? 'Record', $item),
                        'url' => value($source['url'] ?? '#', $item),
                    ];
                });

            $results = $results->merge($items);
        }

        return $results
            ->sortByDesc('sort_date')
            ->take(30)
            ->map(function ($result) {
                unset($result['sort_date']);
                return $result;
            })
            ->values()
            ->all();
    }

    private function extractSearchableFormDataSummary($formData): string
    {
        if (is_array($formData)) {
            return collect($formData)
                ->flatten()
                ->filter(fn ($value) => is_scalar($value) && trim((string) $value) !== '')
                ->take(3)
                ->implode(' | ');
        }

        return is_string($formData) ? $formData : 'School information record';
    }

    private function getCenterProfileModules(): array
    {
        $allowedModuleKeys = [
            'talents_information',
            'skills_information',
            'parents_information',
            'home_visitation',
            'school_visitation',
            'school_primary',
            'school_secondary',
            'school_a_level',
            'school_college',
            'school_university',
            'school_vocational_training',
            'school_others',
            'exam_primary',
            'exam_secondary',
            'exam_a_level',
            'exam_college',
            'exam_university',
            'talent_attendance',
            'skills_attendance',
            'curriculum_attendance',
            'masomo_ya_mtaala',
            'masomo_ya_fani',
            'special_program',
            'base_leader',
            'center_leader',
            'cluster_leader',
            'national_leader',
            'out_of_ministry',
        ];

        return collect(config('reports.modules', []))
            ->only($allowedModuleKeys)
            ->all();
    }

    private function getCenterDataSummary(string $centerId)
    {
        $moduleMeta = [
            'talents_information' => ['icon' => 'bi-star-fill', 'color' => 'warning'],
            'skills_information' => ['icon' => 'bi-tools', 'color' => 'secondary'],
            'parents_information' => ['icon' => 'bi-people-fill', 'color' => 'dark'],
            'home_visitation' => ['icon' => 'bi-house-door', 'color' => 'primary'],
            'school_visitation' => ['icon' => 'bi-building-check', 'color' => 'info'],
            'school_primary' => ['icon' => 'bi-mortarboard', 'color' => 'primary'],
            'school_secondary' => ['icon' => 'bi-book', 'color' => 'info'],
            'school_a_level' => ['icon' => 'bi-bank', 'color' => 'warning'],
            'school_college' => ['icon' => 'bi-award', 'color' => 'success'],
            'school_university' => ['icon' => 'bi-mortarboard-fill', 'color' => 'success'],
            'school_vocational_training' => ['icon' => 'bi-tools', 'color' => 'secondary'],
            'school_others' => ['icon' => 'bi-three-dots', 'color' => 'dark'],
            'exam_primary' => ['icon' => 'bi-1-circle', 'color' => 'primary'],
            'exam_secondary' => ['icon' => 'bi-2-circle', 'color' => 'info'],
            'exam_a_level' => ['icon' => 'bi-3-circle', 'color' => 'warning'],
            'exam_college' => ['icon' => 'bi-mortarboard', 'color' => 'success'],
            'exam_university' => ['icon' => 'bi-bank', 'color' => 'success'],
            'talent_attendance' => ['icon' => 'bi-calendar-check', 'color' => 'primary'],
            'skills_attendance' => ['icon' => 'bi-calendar2-check', 'color' => 'success'],
            'curriculum_attendance' => ['icon' => 'bi-journal-check', 'color' => 'info'],
            'masomo_ya_mtaala' => ['icon' => 'bi-book-half', 'color' => 'primary'],
            'masomo_ya_fani' => ['icon' => 'bi-journal-text', 'color' => 'warning'],
            'special_program' => ['icon' => 'bi-stars', 'color' => 'success'],
            'base_leader' => ['icon' => 'bi-person-badge', 'color' => 'info'],
            'center_leader' => ['icon' => 'bi-geo-alt', 'color' => 'primary'],
            'cluster_leader' => ['icon' => 'bi-diagram-3', 'color' => 'secondary'],
            'national_leader' => ['icon' => 'bi-flag', 'color' => 'danger'],
            'out_of_ministry' => ['icon' => 'bi-box-arrow-right', 'color' => 'dark'],
        ];

        return collect($this->getCenterProfileModules())
            ->map(function ($module, $key) use ($centerId, $moduleMeta) {
                $count = $this->buildCenterModuleQuery($module, $centerId)->count();
                $meta = $moduleMeta[$key] ?? ['icon' => 'bi-folder', 'color' => 'secondary'];

                return [
                    'key' => $key,
                    'title' => $module['title'] ?? ucwords(str_replace('_', ' ', $key)),
                    'count' => $count,
                    'icon' => $meta['icon'],
                    'color' => $meta['color'],
                ];
            })
            ->sortByDesc('count')
            ->values();
    }

    private function buildCenterModuleQuery(array $module, string $centerId)
    {
        $modelClass = $module['model'];
        $query = $modelClass::query();
        $table = (new $modelClass())->getTable();

        if (method_exists($modelClass, 'user')) {
            $query->with('user')
                ->whereHas('user', function ($builder) use ($centerId) {
                    $builder->whereRaw('UPPER(center_id) = ?', [$centerId]);
                });
        } elseif (Schema::hasColumn($table, 'center_id')) {
            $query->whereRaw('UPPER(center_id) = ?', [$centerId]);
        } else {
            $query->whereRaw('1 = 0');
        }

        foreach (($module['where'] ?? []) as $column => $value) {
            $query->where($column, $value);
        }

        return $query;
    }

    private function resolveCenterProfileStartDate(string $period): ?Carbon
    {
        return match ($period) {
            'week' => now()->subWeek(),
            'month' => now()->subMonth(),
            '3months' => now()->subMonths(3),
            '6months' => now()->subMonths(6),
            default => null,
        };
    }

    private function applyCenterProfilePeriod($query, array $module, ?Carbon $startDate)
    {
        if (! $startDate) {
            return $query;
        }

        $table = (new $module['model'])->getTable();

        if (Schema::hasColumn($table, 'date')) {
            return $query->whereDate('date', '>=', $startDate->toDateString());
        }

        if (Schema::hasColumn($table, 'submitted_at')) {
            return $query->whereDate('submitted_at', '>=', $startDate->toDateString());
        }

        return $query->whereDate('created_at', '>=', $startDate->toDateString());
    }

    private function applyCenterProfileSort($query, array $module)
    {
        $table = (new $module['model'])->getTable();

        if (Schema::hasColumn($table, 'date')) {
            return $query->orderByDesc('date');
        }

        if (Schema::hasColumn($table, 'submitted_at')) {
            return $query->orderByDesc('submitted_at');
        }

        return $query->orderByDesc('created_at');
    }
}
