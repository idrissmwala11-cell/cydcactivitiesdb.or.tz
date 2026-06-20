<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\MasomoYaMtaala;
use App\Models\MasomoYaFani;
use App\Models\SpecialProgram;
use App\Support\ProgramDayAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubmissionController extends Controller
{
    protected array $sectionRoutes = [
        'masomo_ya_mtaala' => 'submissions.masomo-ya-mtaala.index',
        'fani' => 'submissions.masomo-ya-fani.index',
        'special_program' => 'submissions.special-program.index',
    ];

    /**
     * Display user dashboard with program sections
     */
    public function dashboard()
    {
        $user = Auth::user();
        $submissions = Submission::where('user_id', $user->id)
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
            ->orderBy('created_at', 'desc')
            ->get();
            
        $masomoSubmissions = MasomoYaMtaala::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        $faniSubmissions = MasomoYaFani::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('submissions.dashboard', compact('submissions', 'masomoSubmissions', 'faniSubmissions'));
    }

    /**
     * Show form for specific program section
     */
    public function create(Request $request)
    {
        $section = $request->get('section', 'masomo_ya_mtaala');
        $validSections = ['masomo_ya_mtaala', 'fani', 'special_program', 'parents', 'vikoba'];
        
        if (!in_array($section, $validSections)) {
            abort(404);
        }
        
        // Check if user already has a draft for this section
        $existingSubmission = Submission::where('user_id', Auth::id())
            ->where('section_type', $section)
            ->where('status', 'draft')
            ->first();
            
        // IMPORTANT: pass as 'submission' to match the blade view expectations
        return view('submissions.create', [
            'section' => $section,
            'submission' => $existingSubmission,
        ]);
    }

    /**
     * Store or update submission
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section_type' => 'required|in:masomo_ya_mtaala,fani,special_program,parents,vikoba',
            'form_data' => 'required|array',
            'action' => 'required|in:save_draft,draft,submit'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $status = $request->action === 'submit' ? 'approved' : 'draft';
        $submittedAt = $request->action === 'submit' ? now() : null;

        $submission = Submission::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'section_type' => $request->section_type,
                'status' => 'draft'
            ],
            [
                'program_type' => 'program_day',
                'form_data' => $request->form_data,
                'status' => $status,
                'submitted_at' => $submittedAt
            ]
        );

        $message = $request->action === 'submit' 
            ? 'Form submitted successfully!' 
            : 'Draft saved successfully!';
            
        return $this->redirectAfterSubmission($submission, $message);
    }

    /**
     * Store Curriculum Studies specific submission
     */
    public function storeMasomoYaMtaala(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tarehe' => 'required|date',
            'jina_la_mwalimu' => 'required|string|max:255',
            'somo_analofundisha' => 'required|string|max:255',
            'kiroho' => 'nullable|in:ndio,hapana',
            'kimwili' => 'nullable|in:ndio,hapana',
            'kiakili' => 'nullable|in:ndio,hapana',
            'kijamii' => 'nullable|in:ndio,hapana',
            'darasa_la_mjaka_mingapi' => 'nullable|string|max:255',
            'mada_aliyo_fundisha' => 'nullable|string',
            'maoni_ya_mwanafunzi' => 'nullable|string',
            'maoni_ya_mwalimu' => 'nullable|string',
            'participant_roster_text' => 'nullable|string',
            'attendance_marker' => 'nullable|string',
            'present_participant_numbers' => 'nullable|array',
            'present_participant_numbers.*' => 'nullable|string',
            'action' => 'required|in:save_draft,draft,submit'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $status = $request->action === 'submit' ? 'approved' : 'draft';
        $submittedAt = $request->action === 'submit' ? now() : null;

        $data = $request->only([
            'tarehe', 'jina_la_mwalimu', 'somo_analofundisha',
            'kiroho', 'kimwili', 'kiakili', 'kijamii',
            'darasa_la_mjaka_mingapi', 'mada_aliyo_fundisha',
            'maoni_ya_mwanafunzi', 'maoni_ya_mwalimu'
        ]);

        $data = array_merge($data, ProgramDayAttendance::fromRequest($request, Auth::id()));
        
        $data['user_id'] = Auth::id();
        $data['status'] = $status;
        $data['submitted_at'] = $submittedAt;

        // Check if user already has a draft
        $existingSubmission = MasomoYaMtaala::where('user_id', Auth::id())
            ->where('status', 'draft')
            ->first();

        if ($existingSubmission) {
            $existingSubmission->update($data);
        } else {
            MasomoYaMtaala::create($data);
        }

        $message = $request->action === 'submit' 
            ? 'Curriculum Studies form submitted successfully!' 
            : 'Curriculum Studies draft saved successfully!';
            
        return redirect()->route('submissions.masomo-ya-mtaala.index')
            ->with('success', $message);
    }

    /**
     * Store Masomo ya Fani specific submission
     */
    public function storeMasomoYaFani(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tarehe_aliyofundisha' => 'required|date',
            'jina_la_mwalimu' => 'required|string|max:255',
            'fani_anayofundisha' => 'required|string|max:255',
            'mada_aliyo_fundisha' => 'required|string|max:255',
            'washiriki_wanapendelea_nini_kwenye_fani_yake' => 'nullable|string',
            'maoni_ya_mwanafunzi' => 'nullable|string',
            'maoni_ya_mwalimu' => 'nullable|string',
            'participant_roster_text' => 'nullable|string',
            'attendance_marker' => 'nullable|string',
            'present_participant_numbers' => 'nullable|array',
            'present_participant_numbers.*' => 'nullable|string',
            'action' => 'required|in:save_draft,draft,submit'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $status = $request->action === 'submit' ? 'approved' : 'draft';
        $submittedAt = $request->action === 'submit' ? now() : null;

        $data = [
            'date' => $request->tarehe_aliyofundisha,
            'teacher' => $request->jina_la_mwalimu,
            'fani_type' => $request->fani_anayofundisha,
            'topic' => $request->mada_aliyo_fundisha,
            'student_preferences' => $request->washiriki_wanapendelea_nini_kwenye_fani_yake,
            'student_feedback' => $request->maoni_ya_mwanafunzi,
            'teacher_feedback' => $request->maoni_ya_mwalimu,
            'user_id' => Auth::id(),
            'status' => $status,
            'submitted_at' => $submittedAt
        ] + ProgramDayAttendance::fromRequest($request, Auth::id());

        // Check if user already has a draft
        $existingSubmission = MasomoYaFani::where('user_id', Auth::id())
            ->where('status', 'draft')
            ->first();

        if ($existingSubmission) {
            $existingSubmission->update($data);
        } else {
            MasomoYaFani::create($data);
        }

        $message = $request->action === 'submit' 
            ? 'Masomo ya Fani form submitted successfully!' 
            : 'Masomo ya Fani draft saved successfully!';
            
        return redirect()->route('submissions.masomo-ya-fani.index')
            ->with('success', $message);
    }

    /**
     * Admin: list submissions with filters
     */
    public function index(Request $request)
    {
        // Get all submission types in one unified view
        $allSubmissions = $this->getAllSubmissions($request);
        
        // Get regular submissions for backward compatibility
        $query = Submission::with('user')->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('section')) {
            $query->where('section_type', $request->input('section'));
        }

        $submissions = $query->paginate(10)->withQueryString();

        return view('submissions.index', compact('submissions', 'allSubmissions'));
    }
    
    /**
     * Get all submissions from different models unified
     */
    private function getAllSubmissions(Request $request)
    {
        $submissions = collect();
        
        // Center Leadership submissions
        $centerLeadership = \App\Models\CenterLeadership::with('user')
            ->when($request->filled('status'), function($query) use ($request) {
                return $query->where('status', $request->input('status'));
            })
            ->latest()
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'type' => 'Center Leadership',
                    'title' => $item->center_name,
                    'user' => $item->user->name ?? 'Unknown',
                    'status' => $item->status,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'model' => 'CenterLeadership',
                    'route_show' => 'center-leadership.show',
                    'route_edit' => 'center-leadership.edit',
                    'route_delete' => 'center-leadership.destroy'
                ];
            });
        
        // Parents Information submissions
        $parentsInfo = \App\Models\ParentsInformation::with('user')
            ->when($request->filled('status'), function($query) use ($request) {
                return $query->where('status', $request->input('status'));
            })
            ->latest()
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'type' => 'Parents Information',
                    'title' => $item->parent_name . ' - ' . $item->parent_of,
                    'user' => $item->user->name ?? 'Unknown',
                    'status' => $item->status ?? 'approved',
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'model' => 'ParentsInformation',
                    'route_show' => 'parents-information.show',
                    'route_edit' => 'parents-information.edit',
                    'route_delete' => 'parents-information.destroy'
                ];
            });
        
        // Base Leaders submissions
        $baseLeaders = \App\Models\BaseLeader::with('user')
            ->when($request->filled('status'), function($query) use ($request) {
                $statusMap = ['pending' => 'pending', 'approved' => 'approved', 'rejected' => 'rejected'];
                if (isset($statusMap[$request->input('status')])) {
                    return $query->where('approval_status', $statusMap[$request->input('status')]);
                }
            })
            ->latest()
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'type' => 'Base Leader',
                    'title' => $item->leader_name . ' - ' . $item->position,
                    'user' => $item->user->name ?? 'Unknown',
                    'status' => $item->approval_status ?? 'pending',
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'model' => 'BaseLeader',
                    'route_show' => 'base-leaders.show',
                    'route_edit' => 'base-leaders.edit',
                    'route_delete' => 'base-leaders.destroy'
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
            'route' => 'submissions.special-program.show', // ✅ FIXED
            'url' => route('submissions.special-program.show', $item->id), // ✅ FIXED
            'id' => $item->id,
            'icon' => 'bi-star',
            'color' => 'warning',
            'status' => 'submitted'
        ];
    });
        
        // Regular submissions (school info, etc.)
        $regularSubmissions = Submission::with('user')
            ->when($request->filled('status'), function($query) use ($request) {
                return $query->where('status', $request->input('status'));
            })
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
            ->get()
            ->map(function($item) {
                $sectionTitles = [
                    'school_primary' => 'Primary School Info',
                    'school_secondary' => 'Secondary School Info',
                    'school_a_level' => 'A-Level School Info',
                    'school_university' => 'University Info',
                    'school_college' => 'College Info',
                    'school_vocational_training' => 'Vocational Training Info',
                    'exam_primary' => 'Primary Exam Results',
                    'exam_secondary' => 'Secondary Exam Results',
                    'exam_a_level' => 'A-Level Exam Results',
                    'exam_college' => 'College Exam Results',
                    'exam_university' => 'University Exam Results',
                    'masomo_ya_mtaala' => 'Curriculum Lesson',
                    'fani' => 'Subject Information',
                    'special_program' => 'Special Program',
                    'parents' => 'Parents Information',
                    'vikoba' => 'Savings Group Info'
                ];
                
                return [
                    'id' => $item->id,
                    'type' => $sectionTitles[$item->section_type] ?? ucwords(str_replace('_', ' ', $item->section_type)),
                    'title' => $sectionTitles[$item->section_type] ?? 'Submission',
                    'user' => $item->user->name ?? 'Unknown',
                    'status' => $item->status,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'model' => 'Submission',
                    'route_show' => 'admin.submissions.show',
                    'route_edit' => 'admin.submissions.edit',
                    'route_delete' => 'admin.submissions.destroy'
                ];
            });
        
        // Merge all submissions and sort by date
        $allSubmissions = $submissions
            ->merge($centerLeadership)
            ->merge($parentsInfo)
            ->merge($baseLeaders)
            ->merge($specialPrograms)
            ->merge($regularSubmissions)
            ->sortByDesc('created_at');
        
        return $allSubmissions;
    }

    /**
     * Admin: show a single submission in detail
     */
    public function show(Submission $submission)
    {
        $this->authorizeSubmissionAccess($submission);
        $submission->load('user');
        return view('submissions.show', compact('submission'));
    }

    /**


    /**
     * User: delete a draft submission
     */
    public function destroy(Submission $submission)
    {
        if (Auth::id() !== $submission->user_id && Auth::user()?->role !== 'admin') {
            abort(403);
        }
        if ($submission->status !== 'draft') {
            return back()->with('error', 'Only draft submissions can be deleted.');
        }
        $submission->delete();
        return redirect()->route('submissions.dashboard')->with('success', 'Draft deleted successfully.');
    }

    /**
     * Admin: edit a submission's form data
     */
    public function edit(Submission $submission)
    {
        $this->authorizeSubmissionAccess($submission);
        $submission->load('user');
        return view('submissions.edit', compact('submission'));
    }

    /**
     * Update a submission's form data (admin or user context)
     */
    public function update(Request $request, Submission $submission)
    {
        $this->authorizeSubmissionAccess($submission);

        $validated = $request->validate([
            'form_data' => 'required|array'
        ]);

        $submission->form_data = $validated['form_data'];
        $submission->save();

        // Redirect based on context (admin vs user)
        if ($request->is('admin/*')) {
            return redirect()->route('admin.submissions.show', $submission)
                ->with('success', 'Submission updated successfully.');
        }

        return $this->redirectAfterSubmission($submission, 'Submission updated successfully.');
    }

    /**
     * Admin: delete any submission
     */
    public function adminDestroy(Submission $submission)
    {
        $submission->delete();
        return redirect()->route('admin.submissions.index')->with('success', 'Submission deleted successfully.');
    }

    private function authorizeSubmissionAccess(Submission $submission): void
    {
        $user = Auth::user();

        if (! $user) {
            abort(403);
        }

        if ($user->role === 'admin' || $submission->user_id === $user->id) {
            return;
        }

        abort(403);
    }

    private function redirectAfterSubmission(Submission $submission, string $message)
    {
        $routeName = $this->sectionRoutes[$submission->section_type] ?? null;

        if ($routeName) {
            return redirect()->route($routeName)
                ->with('success', $message);
        }

        return redirect()->route('submissions.dashboard')
            ->with('success', $message);
    }
}
