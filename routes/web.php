<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TalentController;
use App\Http\Controllers\TalentAttendanceController;
use App\Http\Controllers\SkillsInformationController;
use App\Http\Controllers\SkillsAttendanceController;
use App\Http\Controllers\CurriculumAttendanceController;
use App\Http\Controllers\HomeVisitationController;
use App\Http\Controllers\SchoolVisitationController;
use App\Http\Controllers\LocalSponsorshipController;
use App\Http\Controllers\ExamResultsController;
use App\Http\Controllers\ParentsInformationController;
use App\Http\Controllers\SpecialProgramController;
use App\Http\Controllers\VocationalTrainingController;
use App\Http\Controllers\SavingGroupController;
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
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\SkillVideoController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerformanceReportController;
use App\Http\Controllers\FormTwoResultsController;
use App\Http\Controllers\UserAvatarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public landing page
Route::get('/', function () {
    return view('welcome');
});

Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Dashboard routes
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.dashboard');

// User approval routes
Route::middleware(['auth'])->group(function () {

    Route::get('/users/{user}/avatar', UserAvatarController::class)->name('users.avatar');
    Route::get('/approval/pending', fn() => view('auth.approval-pending'))->name('approval.pending');
    Route::get('/approval/rejected', fn() => view('auth.approval-rejected'))->name('approval.rejected');
});

Route::middleware(['auth', 'form-two-results.access'])
    ->prefix('form-two-results')
    ->name('form-two-results.')
    ->group(function () {
        Route::get('/', [FormTwoResultsController::class, 'index'])->name('index');

        Route::get('/subjects', [FormTwoResultsController::class, 'subjects'])->name('subjects.index');
        Route::put('/subjects', [FormTwoResultsController::class, 'updateSubjects'])->name('subjects.update');

        Route::get('/students', [FormTwoResultsController::class, 'students'])->name('students.index');
        Route::post('/students', [FormTwoResultsController::class, 'storeStudent'])->name('students.store');
        Route::get('/students/{student}/edit', [FormTwoResultsController::class, 'editStudent'])->name('students.edit');
        Route::put('/students/{student}', [FormTwoResultsController::class, 'updateStudent'])->name('students.update');
        Route::delete('/students/{student}', [FormTwoResultsController::class, 'destroyStudent'])->name('students.destroy');

        Route::get('/assessments', [FormTwoResultsController::class, 'assessments'])->name('assessments.index');
        Route::post('/assessments', [FormTwoResultsController::class, 'storeAssessment'])->name('assessments.store');
        Route::put('/assessments/{assessment}', [FormTwoResultsController::class, 'updateAssessment'])->name('assessments.update');
        Route::delete('/assessments/{assessment}', [FormTwoResultsController::class, 'destroyAssessment'])->name('assessments.destroy');

        Route::get('/marks', [FormTwoResultsController::class, 'marks'])->name('marks.index');
        Route::put('/marks/{assessment}', [FormTwoResultsController::class, 'storeMarks'])->name('marks.store');
        Route::get('/results', [FormTwoResultsController::class, 'results'])->name('results.index');
        Route::get('/analysis', [FormTwoResultsController::class, 'analysis'])->name('analysis.index');
        Route::get('/reports', [FormTwoResultsController::class, 'reports'])->name('reports.index');
        Route::get('/reports/{student}', [FormTwoResultsController::class, 'report'])->name('reports.show');
    });

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');

    /*
    |--------------------------------------------------------------------------
    | CORE RESOURCES
    |--------------------------------------------------------------------------
    */
    Route::resource('talents', TalentController::class);
    Route::resource('talent-attendance', TalentAttendanceController::class);
    Route::resource('skills-information', SkillsInformationController::class);
    Route::resource('skills-attendance', SkillsAttendanceController::class);
    Route::resource('curriculum-attendance', CurriculumAttendanceController::class);
    Route::resource('home-visitation', HomeVisitationController::class);
    Route::resource('school-visitation', SchoolVisitationController::class);
    if (config('features.local_sponsorship_visible')) {
        Route::resource('local-sponsorship', LocalSponsorshipController::class);
    }
    Route::resource('parents-information', ParentsInformationController::class);
    Route::resource('vocational-training', VocationalTrainingController::class);
    Route::resource('saving-groups', SavingGroupController::class);

    /*
    |--------------------------------------------------------------------------
    | LEADERSHIP
    |--------------------------------------------------------------------------
    */
    Route::resource('base-leaders', BaseLeaderController::class);
    Route::resource('cluster-leadership', ClusterLeaderController::class);
    Route::resource('national-leadership', NationalLeaderController::class);
    Route::resource('out-of-ministry-leadership', OutOfMinistryLeaderController::class);
    Route::resource('center-leadership', CenterLeadershipController::class);

    /*
    |--------------------------------------------------------------------------
    | ADDITIONAL MANAGEMENT
    |--------------------------------------------------------------------------
    */
    Route::resource('participants', ParticipantController::class);
    Route::resource('sessions', SessionController::class);
    Route::resource('programs', ProgramController::class);
    Route::resource('skills', SkillController::class);

    /*
    |--------------------------------------------------------------------------
    | USER SUBMISSIONS
    |--------------------------------------------------------------------------
    */
    Route::get('/user-dashboard', [SubmissionController::class, 'dashboard'])->name('submissions.dashboard');
    Route::get('/submissions/create', [SubmissionController::class, 'create'])->name('submissions.create');
    Route::post('/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::get('/submissions/{submission}', [SubmissionController::class, 'show'])->whereNumber('submission')->name('submissions.show');
    Route::get('/submissions/{submission}/edit', [SubmissionController::class, 'edit'])->whereNumber('submission')->name('submissions.edit');
    Route::put('/submissions/{submission}', [SubmissionController::class, 'update'])->whereNumber('submission')->name('submissions.update');
    Route::delete('/submissions/{submission}', [SubmissionController::class, 'destroy'])->whereNumber('submission')->name('submissions.destroy');

    /*
    |--------------------------------------------------------------------------
    | MASOMO YA MTAALA - USER SIDE
    |--------------------------------------------------------------------------
    */
    Route::prefix('submissions/masomo-ya-mtaala')
        ->name('submissions.masomo-ya-mtaala.')
        ->group(function () {
            Route::get('/', [MasomoYaMtaalaController::class, 'index'])->name('index');
            Route::get('/create', [MasomoYaMtaalaController::class, 'create'])->name('create');
            Route::post('/', [MasomoYaMtaalaController::class, 'store'])->name('store');
            Route::get('/{masomoYaMtaala}', [MasomoYaMtaalaController::class, 'show'])->name('show');
            Route::get('/{masomoYaMtaala}/edit', [MasomoYaMtaalaController::class, 'edit'])->name('edit');
            Route::put('/{masomoYaMtaala}', [MasomoYaMtaalaController::class, 'update'])->name('update');
            Route::delete('/{masomoYaMtaala}', [MasomoYaMtaalaController::class, 'destroy'])->name('destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | MASOMO YA FANI - USER SIDE
    |--------------------------------------------------------------------------
    */
    Route::prefix('submissions/masomo-ya-fani')
        ->name('submissions.masomo-ya-fani.')
        ->group(function () {
            Route::get('/', [MasomoYaFaniController::class, 'index'])->name('index');
            Route::get('/create', [MasomoYaFaniController::class, 'create'])->name('create');
            Route::post('/', [MasomoYaFaniController::class, 'store'])->name('store');
            Route::get('/{masomoYaFani}', [MasomoYaFaniController::class, 'show'])->name('show');
            Route::get('/{masomoYaFani}/edit', [MasomoYaFaniController::class, 'edit'])->name('edit');
            Route::put('/{masomoYaFani}', [MasomoYaFaniController::class, 'update'])->name('update');
            Route::delete('/{masomoYaFani}', [MasomoYaFaniController::class, 'destroy'])->name('destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | SPECIAL PROGRAM
    |--------------------------------------------------------------------------
    */
    Route::prefix('special-program')
        ->name('submissions.special-program.')
        ->group(function () {
            Route::get('/', [SpecialProgramController::class, 'index'])->name('index');
            Route::get('/create', [SpecialProgramController::class, 'create'])->name('create');
            Route::post('/', [SpecialProgramController::class, 'store'])->name('store');
            Route::get('/{special_program}', [SpecialProgramController::class, 'show'])->name('show');
            Route::get('/{special_program}/edit', [SpecialProgramController::class, 'edit'])->name('edit');
            Route::put('/{special_program}', [SpecialProgramController::class, 'update'])->name('update');
            Route::delete('/{special_program}', [SpecialProgramController::class, 'destroy'])->name('destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | SCHOOL INFORMATION
    |--------------------------------------------------------------------------
    | Hapa tumeweka index-style naming ili menu ifungue records page kwanza
    | Badilisha sidebar links kwenda:
    | route('school-info.primary.index')
    | route('school-info.secondary.index')
    | n.k.
    |--------------------------------------------------------------------------
    */
    Route::prefix('school-info')
        ->name('school-info.')
        ->group(function () {
            foreach (['primary', 'secondary', 'a-level', 'university', 'college', 'vocational-training', 'others'] as $sectionKey) {
                Route::get("/{$sectionKey}", [SchoolInformationController::class, 'index'])
                    ->name("{$sectionKey}.index")
                    ->defaults('sectionKey', $sectionKey);

                Route::get("/{$sectionKey}/create", [SchoolInformationController::class, 'create'])
                    ->name("{$sectionKey}.create")
                    ->defaults('sectionKey', $sectionKey);

                Route::post("/{$sectionKey}", [SchoolInformationController::class, 'store'])
                    ->name("{$sectionKey}.store")
                    ->defaults('sectionKey', $sectionKey);

                Route::get("/{$sectionKey}/{schoolInformationRecord}", [SchoolInformationController::class, 'show'])
                    ->name("{$sectionKey}.show")
                    ->defaults('sectionKey', $sectionKey);

                Route::get("/{$sectionKey}/{schoolInformationRecord}/edit", [SchoolInformationController::class, 'edit'])
                    ->name("{$sectionKey}.edit")
                    ->defaults('sectionKey', $sectionKey);

                Route::put("/{$sectionKey}/{schoolInformationRecord}", [SchoolInformationController::class, 'update'])
                    ->name("{$sectionKey}.update")
                    ->defaults('sectionKey', $sectionKey);

                Route::delete("/{$sectionKey}/{schoolInformationRecord}", [SchoolInformationController::class, 'destroy'])
                    ->name("{$sectionKey}.destroy")
                    ->defaults('sectionKey', $sectionKey);
            }
        });

    Route::prefix('exam-results')
        ->name('exam-results.')
        ->group(function () {
            foreach (['primary', 'secondary', 'a-level', 'college', 'university'] as $sectionKey) {
                Route::get("/{$sectionKey}", [ExamResultsController::class, 'index'])
                    ->name("{$sectionKey}.index")
                    ->defaults('sectionKey', $sectionKey);

                Route::get("/{$sectionKey}/create", [ExamResultsController::class, 'create'])
                    ->name("{$sectionKey}.create")
                    ->defaults('sectionKey', $sectionKey);

                Route::post("/{$sectionKey}", [ExamResultsController::class, 'store'])
                    ->name("{$sectionKey}.store")
                    ->defaults('sectionKey', $sectionKey);

                Route::get("/{$sectionKey}/{examResult}", [ExamResultsController::class, 'show'])
                    ->name("{$sectionKey}.show")
                    ->defaults('sectionKey', $sectionKey);

                Route::get("/{$sectionKey}/{examResult}/edit", [ExamResultsController::class, 'edit'])
                    ->name("{$sectionKey}.edit")
                    ->defaults('sectionKey', $sectionKey);

                Route::put("/{$sectionKey}/{examResult}", [ExamResultsController::class, 'update'])
                    ->name("{$sectionKey}.update")
                    ->defaults('sectionKey', $sectionKey);

                Route::delete("/{$sectionKey}/{examResult}", [ExamResultsController::class, 'destroy'])
                    ->name("{$sectionKey}.destroy")
                    ->defaults('sectionKey', $sectionKey);
            }
        });

    /*
    |--------------------------------------------------------------------------
    | USER SETTINGS
    |--------------------------------------------------------------------------
    */
    Route::put('/user/settings', [UserController::class, 'updateSettings'])->name('user.settings.update');
    Route::post('/user/theme', [UserController::class, 'updateTheme'])
        ->name('user.update-theme')
        ->middleware('auth');

    /*
    |--------------------------------------------------------------------------
    | ANNOUNCEMENTS
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/announcements', [AnnouncementController::class, 'index'])->name('admin.announcements.index');
    Route::get('/admin/announcements/create', [AnnouncementController::class, 'create'])->name('admin.announcements.create');
    Route::post('/admin/announcements', [AnnouncementController::class, 'store'])->name('admin.announcements.store');

    Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])
        ->name('announcements.show');
    Route::post('/announcements/mark-all-read', [AnnouncementController::class, 'markAllRead'])
        ->name('announcements.mark-all-read');

    /*
    |--------------------------------------------------------------------------
    | REPORTS
    |--------------------------------------------------------------------------
    */
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/run', [ReportController::class, 'run'])->name('reports.run');
    Route::get('/reports/print', [ReportController::class, 'print'])->name('reports.print');
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/data', [ChatController::class, 'data'])->name('chat.data');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');

    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */
    Route::get('/user/search', [DashboardController::class, 'userSearch'])->name('user.search');
    Route::post('/user/search/ajax', [DashboardController::class, 'userSearchAjax'])->name('user.search.ajax');
});

/*
|--------------------------------------------------------------------------
| SKILL VIDEOS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/skill-videos', [SkillVideoController::class, 'index'])->name('admin.skill-videos.index');
    Route::get('/admin/skill-videos/create', [SkillVideoController::class, 'create'])->name('admin.skill-videos.create');
    Route::post('/admin/skill-videos', [SkillVideoController::class, 'store'])->name('admin.skill-videos.store');
    Route::delete('/admin/skill-videos/{skillVideo}', [SkillVideoController::class, 'destroy'])->name('admin.skill-videos.destroy');
});

Route::get('/skills-to-learn/videos', [SkillVideoController::class, 'publicIndex'])->name('skills-to-learn.videos');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/performance-report', [PerformanceReportController::class, 'index'])
        ->name('admin.performance-report.index');

    Route::post('/admin/performance-report', [PerformanceReportController::class, 'generate'])
        ->name('admin.performance-report.generate');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    Route::get('/users', [DashboardController::class, 'manageUsers'])->name('users.index');
    Route::get('/centers-without-data', [DashboardController::class, 'centersWithoutData'])->name('centers-without-data');
    Route::get('/users/{user}/center-profile', [DashboardController::class, 'showCenterProfile'])->name('users.center-profile');
    Route::patch('/users/{user}', [DashboardController::class, 'updateUser'])->name('users.update');
    Route::patch('/users/{user}/toggle-status', [DashboardController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::patch('/users/{user}/approve', [DashboardController::class, 'approveUser'])->name('users.approve');
    Route::patch('/users/{user}/reject', [DashboardController::class, 'rejectUser'])->name('users.reject');
    Route::delete('/users/{user}', [DashboardController::class, 'deleteUser'])->name('users.delete');

    /*
    |--------------------------------------------------------------------------
    | ADMIN SUBMISSIONS
    |--------------------------------------------------------------------------
    */
    Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/submissions/{submission}', [SubmissionController::class, 'show'])->name('submissions.show');
    Route::patch('/submissions/{submission}/status', [SubmissionController::class, 'updateStatus'])->name('submissions.updateStatus');
    Route::get('/submissions/{submission}/edit', [SubmissionController::class, 'edit'])->name('submissions.edit');
    Route::patch('/submissions/{submission}', [SubmissionController::class, 'update'])->name('submissions.update');
    Route::delete('/submissions/{submission}', [SubmissionController::class, 'adminDestroy'])->name('submissions.destroy');

    /*
    |--------------------------------------------------------------------------
    | MASOMO RESOURCES FOR ADMIN
    |--------------------------------------------------------------------------
    */
    Route::resource('masomo-ya-fani', MasomoYaFaniController::class)
        ->only(['index', 'show', 'edit', 'update', 'destroy'])
        ->parameters(['masomo-ya-fani' => 'masomoYaFani']);

    Route::resource('masomo-ya-mtaala', MasomoYaMtaalaController::class)
        ->only(['index', 'show', 'edit', 'update', 'destroy'])
        ->parameters(['masomo-ya-mtaala' => 'masomoYaMtaala']);

    /*
    |--------------------------------------------------------------------------
    | ADMIN SEARCH
    |--------------------------------------------------------------------------
    */
    Route::get('/search', [DashboardController::class, 'adminSearch'])->name('search');
    Route::post('/search/ajax', [DashboardController::class, 'adminSearchAjax'])->name('search.ajax');
});

require __DIR__ . '/auth.php';
