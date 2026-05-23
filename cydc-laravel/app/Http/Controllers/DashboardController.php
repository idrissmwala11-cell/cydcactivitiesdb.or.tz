<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Participant;
use App\Models\Instructor;
use App\Models\Program;
use App\Models\Session;
use App\Models\Venue;
use App\Models\Skill;
use App\Models\TalentAttendance;
use App\Models\TalentsInformation;
use App\Models\ParentsInformation;
use App\Models\BaseLeader;
use App\Models\SpecialProgram;
use App\Models\MasomoYaMtaala;
use App\Models\CurriculumAttendance;
use App\Models\SkillsAttendance;
use App\Models\SkillsInformation;
use App\Models\Submission;
use App\Models\CenterLeadership;
use App\Models\HomeVisitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only(['admin', 'updateUser', 'deleteUser', 'toggleUserStatus']);
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
            'my_attendance' => TalentAttendance::where('user_id', $user->id)->count(),
            'total_programs' => Program::count(),
            'available_skills' => Skill::count(),
        ];
        
        // User's recent activities only
        $myRecentAttendance = TalentAttendance::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
            
        return view('dashboard.user', compact('stats', 'myRecentAttendance'));
    }

    /**
     * Display the admin dashboard.
     */
    public function admin()
    {
        // Get comprehensive statistics for admin
        $stats = [
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'regular_users' => User::where('role', 'user')->count(),
            'pending_users' => User::where('status', 'pending')->orWhereNull('status')->count(),
            'approved_users' => User::where('status', 'approved')->count(),
            'rejected_users' => User::where('status', 'rejected')->count(),
            'active_users' => User::where('created_at', '>=', now()->subDays(30))->count(), // Users active in last 30 days
            'recent_users' => User::where('created_at', '>=', now()->subDays(7))->count(), // Add this line
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
        
        // Get all users for management (paginated) - Fix relationship name
        $allUsers = User::with(['talentAttendance'])
            ->withCount('talentAttendance')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Get users needing attention - Fix relationship name
        $usersNeedingAttention = User::where(function($query) {
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
            'pendingUsers'
        ));
    }
    
    /**
     * Get count of total submissions across all models
     */
    private function getTotalSubmissionsCount()
    {
        $count = 0;
        // Count all submissions
        $count += ParentsInformation::count();
        $count += BaseLeader::count();
        $count += MasomoYaMtaala::count();
        $count += HomeVisitation::count();
        $count += Submission::count();
        
        return $count;
    }
    
    /**
     * Get recent submissions from various models for admin review
     */
    private function getRecentSubmissions()
    {
        $submissions = collect();
        
        // Parents Information
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
                    'status' => 'submitted'
                ];
            });
        
        // Base Leaders
        $baseLeaders = BaseLeader::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Base Leader',
                    'title' => $item->leader_name . ' - ' . $item->position,
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at, // keep Carbon instance
                    'route' => 'base-leaders.show',
                    'id' => $item->id,
                    'icon' => 'bi-person-badge',
                    'color' => 'success',
                    'status' => 'submitted'
                ];
            });
        
        // Special Programs submissions
        $specialPrograms = SpecialProgram::with('user')
            ->latest()
            ->take(3)
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Special Program',
                    'title' => $item->topic . ' by ' . $item->teacher,
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at,
                    'route' => 'special-programs.show',
                    'id' => $item->id,
                    'icon' => 'bi-star',
                    'color' => 'warning',
                    'status' => 'submitted'
                ];
            });
        
        // Masomo Ya Mtaala submissions
        $masomoYaMtaala = MasomoYaMtaala::with('user')
            ->latest()
            ->take(3)
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Curriculum Lesson',
                    'title' => $item->subject . ' - ' . $item->lesson_topic,
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at,
                    'route' => 'masomo-ya-mtaala.show',
                    'id' => $item->id,
                    'icon' => 'bi-book',
                    'color' => 'info',
                    'status' => 'submitted'
                ];
            });
        
        // Curriculum Attendance submissions
        $curriculumAttendance = CurriculumAttendance::with('user')
            ->latest()
            ->take(3)
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Curriculum Attendance',
                    'title' => $item->somo . ' by ' . $item->jina_la_mwalimu,
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at,
                    'route' => 'curriculum-attendance.show',
                    'id' => $item->id,
                    'icon' => 'bi-calendar-check',
                    'color' => 'secondary',
                    'status' => 'submitted'
                ];
            });
        
        // Skills Attendance submissions
        $skillsAttendance = SkillsAttendance::with('user')
            ->latest()
            ->take(3)
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Skills Attendance',
                    'title' => 'Skills session on ' . $item->date->format('M d, Y'),
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at,
                    'route' => 'skills-attendance.show',
                    'id' => $item->id,
                    'icon' => 'bi-tools',
                    'color' => 'danger',
                    'status' => 'submitted'
                ];
            });
        
        // Home Visitation submissions
        $homeVisitations = HomeVisitation::with('user')
            ->latest()
            ->take(3)
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Home Visitation',
                    'title' => 'Visit to ' . $item->participant_name . ' on ' . $item->visit_date,
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at,
                    'route' => 'home-visitation.show',
                    'id' => $item->id,
                    'icon' => 'bi-house-door',
                    'color' => 'primary',
                    'status' => 'submitted'
                ];
            });
        
        // Center Leadership submissions
        $centerLeadership = CenterLeadership::with('user')
            ->latest()
            ->take(3)
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Center Leadership',
                    'title' => $item->center_name . ' Leadership Info',
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at, // Keep Carbon instance for diffForHumans
                    'route' => 'center-leadership.show',
                    'id' => $item->id,
                    'icon' => 'bi-geo-alt',
                    'color' => 'success',
                    'status' => 'submitted'
                ];
            });
        
        // Talent Information submissions
        $talentSubmissions = TalentsInformation::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Talent Information',
                    'title' => $item->student_name . ' - ' . $item->talent_type,
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at,
                    'route' => 'talents.show',
                    'id' => $item->id,
                    'icon' => 'bi-star-fill',
                    'color' => 'warning',
                    'status' => 'submitted'
                ];
            });
        
        // Skills Information submissions
        $skillsInformation = SkillsInformation::with('user')
            ->latest()
            ->take(3)
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Skills Information',
                    'title' => $item->student_name . ' - ' . $item->skill_category,
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at ?? $item->updated_at ?? now(),
                    'route' => 'skills-information.show',
                    'id' => $item->id,
                    'icon' => 'bi-tools',
                    'color' => 'info',
                    'status' => 'submitted'
                ];
            });
        
        // Submission (program day) items - Enhanced with better titles
        $programDaySubmissions = Submission::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($item) {
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
                    'vikoba' => 'Savings Group Info'
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
                    'status' => 'submitted'
                ];
            });
        
        // Merge all collections and sort by date desc - with safety checks
        $allCollections = collect([
            $parentsInfo,
            $baseLeaders,
            $specialPrograms,
            $masomoYaMtaala,
            $curriculumAttendance,
            $skillsAttendance,
            $skillsInformation,
            $homeVisitations,
            $centerLeadership,
            $talentSubmissions,
            $programDaySubmissions
        ]);
        
        $submissions = collect();
        foreach ($allCollections as $collection) {
            if ($collection && $collection->count() > 0) {
                $submissions = $submissions->merge($collection);
            }
        }
        
        $submissions = $submissions
            ->sortByDesc('date')
            ->values() // Reset keys to avoid getKey() issues
            ->take(12);
        
        return $submissions;
    }
    
    /**
     * Get icon for submission type
     */
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
            'vikoba' => 'bi-piggy-bank'
        ];
        
        return $icons[$sectionType] ?? 'bi-folder';
    }
    
    /**
     * Get color for submission type
     */
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
            'vikoba' => 'secondary'
        ];
        
        return $colors[$sectionType] ?? 'dark';
    }

    /**
     * Update user information and role
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'center_id' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
            'status' => 'required|in:active,inactive',
        ]);
        
        $user->update([
            'center_id' => $request->center_id,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ]);
        
        return redirect()->back()->with('success', 'User updated successfully!');
    }
    
    /**
     * Toggle user status (active/inactive)
     */
    public function toggleUserStatus(User $user)
    {
        $user->update([
            'status' => $user->status === 'active' ? 'inactive' : 'active'
        ]);
        
        return redirect()->back()->with('success', 'User status updated successfully!');
    }
    
    /**
     * Delete user account
     */
    public function deleteUser(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account!');
        }
        
        $user->delete();
        
        return redirect()->back()->with('success', 'User deleted successfully!');
    }
    
    /**
     * Display users for management
     */
    public function manageUsers()
    {
        $users = User::with('approvedBy')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Approve user account
     */
    public function approveUser(User $user)
    {
        $user->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id()
        ]);
        
        return redirect()->back()->with('success', 'User approved successfully!');
    }
    
    /**
     * Reject user account
     */
    public function rejectUser(User $user)
    {
        $user->update([
            'status' => 'rejected',
            'approved_at' => now(),
            'approved_by' => auth()->id()
        ]);
        
        return redirect()->back()->with('success', 'User rejected successfully!');
    }
    
    /**
     * Admin search functionality - search all submissions
     */
    public function adminSearch(Request $request)
    {
        $query = $request->get('q', '');
        $results = [];
        
        if ($query) {
            $results = $this->searchAllSubmissions($query);
        }
        
        return view('admin.search', compact('results', 'query'));
    }
    
    /**
     * Admin Ajax search
     */
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
            'count' => count($results)
        ]);
    }
    
    /**
     * User search functionality - search only their own submissions
     */
    public function userSearch(Request $request)
    {
        $query = $request->get('q', '');
        $results = [];
        
        if ($query) {
            $results = $this->searchUserSubmissions($query, auth()->id());
        }
        
        return view('user.search', compact('results', 'query'));
    }
    
    /**
     * User Ajax search
     */
    public function userSearchAjax(Request $request)
    {
        $query = $request->get('q', '');
        $results = [];
        
        if ($query) {
            $results = $this->searchUserSubmissions($query, auth()->id());
        }
        
        return response()->json([
            'success' => true,
            'results' => $results,
            'count' => count($results)
        ]);
    }
    
    /**
     * Search all submissions (admin only)
     */
    private function searchAllSubmissions($query)
    {
        $results = [];
        
        // Search Parents Information
        $parentsInfo = ParentsInformation::with('user')
            ->where(function($q) use ($query) {
                $q->where('parent_name', 'LIKE', "%{$query}%")
                  ->orWhere('parent_of', 'LIKE', "%{$query}%")
                  ->orWhere('activity', 'LIKE', "%{$query}%")
                  ->orWhere('support_type', 'LIKE', "%{$query}%");
            })
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Parents Information',
                    'title' => $item->parent_name . ' - ' . $item->parent_of,
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at->format('M d, Y'),
                    'route' => 'parents-information.show',
                    'url' => route('parents-information.show', $item->id),
                    'id' => $item->id,
                    'status' => $item->status ?? 'pending'
                ];
            });
            
        // Search Center Leadership
        $centerLeadership = CenterLeadership::with('user')
            ->where(function($q) use ($query) {
                $q->where('center_name', 'LIKE', "%{$query}%")
                  ->orWhere('leadership_list', 'LIKE', "%{$query}%")
                  ->orWhere('challenges', 'LIKE', "%{$query}%")
                  ->orWhere('feedback', 'LIKE', "%{$query}%");
            })
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Center Leadership',
                    'title' => $item->center_name . ' Leadership',
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at->format('M d, Y'),
                    'route' => 'center-leadership.show',
                    'url' => route('center-leadership.show', $item->id),
                    'id' => $item->id,
                    'status' => $item->status ?? 'pending'
                ];
            });
            
        // Search Special Programs
        $specialPrograms = SpecialProgram::with('user')
            ->where(function($q) use ($query) {
                $q->where('topic', 'LIKE', "%{$query}%")
                  ->orWhere('teacher', 'LIKE', "%{$query}%")
                  ->orWhere('age_range', 'LIKE', "%{$query}%")
                  ->orWhere('teacher_feedback', 'LIKE', "%{$query}%")
                  ->orWhere('supervisor_feedback', 'LIKE', "%{$query}%");
            })
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Special Program',
                    'title' => $item->topic . ' by ' . $item->teacher,
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at->format('M d, Y'),
                    'route' => 'special-programs.show',
                    'url' => route('special-programs.show', $item->id),
                    'id' => $item->id,
                    'status' => 'submitted'
                ];
            });
            
        // Merge all results
        $results = $parentsInfo->merge($centerLeadership)->merge($specialPrograms);
        
        return $results->sortByDesc('date')->values()->all();
    }
    
    /**
     * Search user's own submissions only
     */
    private function searchUserSubmissions($query, $userId)
    {
        $results = [];
        
        // Search user's Parents Information
        $parentsInfo = ParentsInformation::with('user')
            ->where('user_id', $userId)
            ->where(function($q) use ($query) {
                $q->where('parent_name', 'LIKE', "%{$query}%")
                  ->orWhere('parent_of', 'LIKE', "%{$query}%")
                  ->orWhere('activity', 'LIKE', "%{$query}%")
                  ->orWhere('support_type', 'LIKE', "%{$query}%");
            })
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Parents Information',
                    'title' => $item->parent_name . ' - ' . $item->parent_of,
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at->format('M d, Y'),
                    'route' => 'parents-information.show',
                    'url' => route('parents-information.show', $item->id),
                    'id' => $item->id,
                    'status' => $item->status ?? 'pending'
                ];
            });
            
        // Search user's Center Leadership
        $centerLeadership = CenterLeadership::with('user')
            ->where('user_id', $userId)
            ->where(function($q) use ($query) {
                $q->where('center_name', 'LIKE', "%{$query}%")
                  ->orWhere('leadership_list', 'LIKE', "%{$query}%")
                  ->orWhere('challenges', 'LIKE', "%{$query}%")
                  ->orWhere('feedback', 'LIKE', "%{$query}%");
            })
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Center Leadership',
                    'title' => $item->center_name . ' Leadership',
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at->format('M d, Y'),
                    'route' => 'center-leadership.show',
                    'url' => route('center-leadership.show', $item->id),
                    'id' => $item->id,
                    'status' => $item->status ?? 'pending'
                ];
            });
            
        // Search user's Special Programs
        $specialPrograms = SpecialProgram::with('user')
            ->where('user_id', $userId)
            ->where(function($q) use ($query) {
                $q->where('topic', 'LIKE', "%{$query}%")
                  ->orWhere('teacher', 'LIKE', "%{$query}%")
                  ->orWhere('age_range', 'LIKE', "%{$query}%")
                  ->orWhere('teacher_feedback', 'LIKE', "%{$query}%")
                  ->orWhere('supervisor_feedback', 'LIKE', "%{$query}%");
            })
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Special Program',
                    'title' => $item->topic . ' by ' . $item->teacher,
                    'user' => $item->user->center_id ?? 'No Center ID',
                    'date' => $item->created_at->format('M d, Y'),
                    'route' => 'special-programs.show',
                    'url' => route('special-programs.show', $item->id),
                    'id' => $item->id,
                    'status' => 'submitted'
                ];
            });
            
        // Merge all results
        $results = $parentsInfo->merge($centerLeadership)->merge($specialPrograms);
        
        return $results->sortByDesc('date')->values()->all();
    }
}