<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TalentController;
use App\Http\Controllers\TalentAttendanceController;
use App\Http\Controllers\SkillsInformationController;
use App\Http\Controllers\SkillsAttendanceController;
use App\Http\Controllers\CurriculumAttendanceController;
use App\Http\Controllers\HomeVisitationController;

use App\Http\Controllers\ParentsInformationController;
use App\Http\Controllers\SpecialProgramController;
use App\Http\Controllers\VocationalTrainingController;
use App\Http\Controllers\SavingGroupController;
use App\Http\Controllers\GroupMemberController;
use App\Http\Controllers\BaseLeaderController;
use App\Http\Controllers\ClusterLeaderController;
use App\Http\Controllers\NationalLeaderController;
use App\Http\Controllers\OutOfMinistryLeaderController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\SessionController;

use App\Http\Controllers\ProgramController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\MasomoYaMtaalaController;
use App\Http\Controllers\MasomoYaFaniController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\SchoolInformationController;
use App\Http\Controllers\CenterLeadershipController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->middleware(['auth', 'verified', 'admin'])->name('admin.dashboard');

// User approval routes
Route::middleware(['auth'])->group(function () {
    Route::get('/approval/pending', function () {
        return view('auth.approval-pending');
    })->name('approval.pending');
    
    Route::get('/approval/rejected', function () {
        return view('auth.approval-rejected');
    })->name('approval.rejected');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Talent Management Routes
    Route::resource('talents', TalentController::class);
    Route::resource('talent-attendance', TalentAttendanceController::class);
    
    // Skills Management Routes
    Route::resource('skills-information', SkillsInformationController::class);
    Route::resource('skills-attendance', SkillsAttendanceController::class);
    
    // Curriculum Management Routes
    Route::resource('curriculum-attendance', CurriculumAttendanceController::class);
    
    // Home Visitation Routes
    Route::resource('home-visitation', HomeVisitationController::class);

    
    // Parents Information Routes
    Route::resource('parents-information', ParentsInformationController::class);

    
    // Special Programs Routes
    Route::resource('special-programs', SpecialProgramController::class);
    Route::resource('vocational-training', VocationalTrainingController::class);
    
    // Saving Groups Management Routes
    Route::resource('saving-groups', SavingGroupController::class);
    Route::resource('group-members', GroupMemberController::class);
    
    // Base Leaders Routes
    Route::resource('base-leaders', BaseLeaderController::class);
    
    // Leadership Information Routes
    Route::resource('cluster-leadership', ClusterLeaderController::class);
    Route::resource('national-leadership', NationalLeaderController::class);
    Route::resource('out-of-ministry-leadership', OutOfMinistryLeaderController::class);

    
    // Additional Management Routes (referenced in dashboard)
    Route::resource('participants', ParticipantController::class);
    Route::resource('sessions', SessionController::class);

    Route::resource('programs', ProgramController::class);
    Route::resource('venues', VenueController::class);
    Route::resource('skills', SkillController::class);
    Route::resource('reports', ReportController::class);
    Route::resource('evaluations', EvaluationController::class);
    Route::resource('masomo-ya-mtaala', MasomoYaMtaalaController::class);

    
    // User Submission Routes
    Route::get('/user-dashboard', [SubmissionController::class, 'dashboard'])->name('submissions.dashboard');
    Route::get('/submissions/create', [SubmissionController::class, 'create'])->name('submissions.create');
    Route::post('/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::put('/submissions/{submission}', [SubmissionController::class, 'update'])->name('submissions.update');
    Route::delete('/submissions/{submission}', [SubmissionController::class, 'destroy'])->name('submissions.destroy');
    
    // Masomo ya Mtaala specific routes
    Route::get('/masomo-ya-mtaala', function() {
        $existingSubmission = \App\Models\MasomoYaMtaala::where('user_id', auth()->id())
            ->where('status', 'draft')
            ->first();
        return view('submissions.masomo-ya-mtaala', compact('existingSubmission'));
    })->name('submissions.masomo-ya-mtaala');
    Route::post('/masomo-ya-mtaala', [SubmissionController::class, 'storeMasomoYaMtaala'])->name('submissions.masomo-ya-mtaala.store');
    
    // Masomo ya Fani specific routes
    Route::get('/masomo-ya-fani', function() {
        $existingSubmission = \App\Models\MasomoYaFani::where('user_id', auth()->id())
            ->where('status', 'draft')
            ->first();
        // Pass existingSubmission as submission for compatibility with create.blade.php
        $submission = $existingSubmission;
        return view('submissions.masomo-ya-fani', compact('existingSubmission', 'submission'));
    })->name('submissions.masomo-ya-fani');
    Route::post('/masomo-ya-fani', [SubmissionController::class, 'storeMasomoYaFani'])->name('submissions.masomo-ya-fani.store');

    // Special Program (generic submission-based)
    Route::get('/special-program', function() {
        $submission = \App\Models\Submission::where('user_id', auth()->id())
            ->where('section_type', 'special_program')
            ->where('status', 'draft')
            ->first();
        return view('submissions.special-program', compact('submission'));
    })->name('submissions.special-program');
    Route::post('/special-program', function(\Illuminate\Http\Request $request) {
        // Map flat inputs to generic form_data structure
        $request->merge([
            'section_type' => 'special_program',
            'form_data' => [
                'date' => $request->input('date'),
                'teacher' => $request->input('teacher'),
                'topic' => $request->input('topic'),
                'age_range' => $request->input('age_range'),
                'teacher_feedback' => $request->input('teacher_feedback'),
                'supervisor_feedback' => $request->input('supervisor_feedback'),
            ],
            'action' => $request->input('action') === 'submit' ? 'submit' : 'save_draft'
        ]);
        return app(SubmissionController::class)->store($request);
    })->name('submissions.special-program.store');
    
    // School Information Routes
    Route::get('/school-info/primary', [SchoolInformationController::class, 'primary'])->name('school-info.primary');
    Route::get('/school-info/secondary', [SchoolInformationController::class, 'secondary'])->name('school-info.secondary');
    Route::get('/school-info/a-level', [SchoolInformationController::class, 'aLevel'])->name('school-info.a-level');
    Route::get('/school-info/university', [SchoolInformationController::class, 'university'])->name('school-info.university');
    Route::get('/school-info/college', [SchoolInformationController::class, 'college'])->name('school-info.college');
    Route::get('/school-info/vocational-training', [SchoolInformationController::class, 'vocationalTraining'])->name('school-info.vocational-training');
    Route::get('/school-info/others', [SchoolInformationController::class, 'others'])->name('school-info.others');
    
    // Admin user management routes
    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        
        // User management routes
        Route::get('/users', [DashboardController::class, 'manageUsers'])->name('users.index');
        Route::patch('/users/{user}', [DashboardController::class, 'updateUser'])->name('users.update');
        Route::patch('/users/{user}/toggle-status', [DashboardController::class, 'toggleUserStatus'])->name('users.toggle-status');
        Route::patch('/users/{user}/approve', [DashboardController::class, 'approveUser'])->name('users.approve');
        Route::patch('/users/{user}/reject', [DashboardController::class, 'rejectUser'])->name('users.reject');
        Route::delete('/users/{user}', [DashboardController::class, 'deleteUser'])->name('users.delete');
        

        
        // Admin Submission Management Routes
        Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
        Route::get('/submissions/{submission}', [SubmissionController::class, 'show'])->name('submissions.show');
        Route::patch('/submissions/{submission}/status', [SubmissionController::class, 'updateStatus'])->name('submissions.updateStatus');
        
        // Admin Search Routes
        Route::get('/search', [DashboardController::class, 'adminSearch'])->name('search');
        Route::post('/search/ajax', [DashboardController::class, 'adminSearchAjax'])->name('search.ajax');

        // Admin Submission Edit/Update/Delete
        Route::get('/submissions/{submission}/edit', [SubmissionController::class, 'edit'])->name('submissions.edit');
        Route::patch('/submissions/{submission}', [SubmissionController::class, 'update'])->name('submissions.update');
        Route::delete('/submissions/{submission}', [SubmissionController::class, 'adminDestroy'])->name('submissions.destroy');

        // Admin: Masomo ya Fani resource listing/editing
        Route::resource('masomo-ya-fani', MasomoYaFaniController::class)
            ->only(['index','show','edit','update','destroy'])
            ->parameters([
                'masomo-ya-fani' => 'masomoYaFani'
            ]);

        // Admin: Masomo ya Mtaala resource listing/editing
        Route::resource('masomo-ya-mtaala', MasomoYaMtaalaController::class)
            ->only(['index','show','edit','update','destroy'])
            ->parameters([
                'masomo-ya-mtaala' => 'masomoYaMtaala'
            ]);
            

    });
    
    // User Search Routes (for authenticated users)
    Route::get('/user/search', [DashboardController::class, 'userSearch'])->name('user.search');
    Route::post('/user/search/ajax', [DashboardController::class, 'userSearchAjax'])->name('user.search.ajax');
    
    // Center Leadership Routes (for all authenticated users)
    Route::resource('center-leadership', CenterLeadershipController::class);
});

require __DIR__.'/auth.php';
