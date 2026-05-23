<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExamResultsController extends Controller
{
    protected array $sections = [
        'primary' => [
            'title' => 'Primary Exam Results',
            'route' => 'exam-results.primary',
            'report_module' => 'exam_primary',
            'class_options' => ['Grade 4', 'Grade 5', 'Grade 6', 'Grade 7'],
            'exam_options' => [
                'Midterm - March',
                'Midterm - September',
                'Terminal',
                'Annual',
                'National Exam - Grade 4',
                'National Exam - Grade 7',
            ],
            'uses_gpa' => false,
        ],
        'secondary' => [
            'title' => 'Secondary Exam Results',
            'route' => 'exam-results.secondary',
            'report_module' => 'exam_secondary',
            'class_options' => ['Form 1', 'Form 2', 'Form 3', 'Form 4'],
            'exam_options' => [
                'Midterm - March',
                'Midterm - September',
                'Terminal',
                'Annual',
                'National Exam - Form 2',
                'National Exam - Form 4',
            ],
            'uses_gpa' => false,
        ],
        'a-level' => [
            'title' => 'A-Level Exam Results',
            'route' => 'exam-results.a-level',
            'report_module' => 'exam_a_level',
            'class_options' => ['Form 5', 'Form 6'],
            'exam_options' => [
                'Midterm - March',
                'Midterm - September',
                'Terminal',
                'Annual',
                'National Exam - Form 6',
            ],
            'uses_gpa' => false,
        ],
        'college' => [
            'title' => 'College Exam Results',
            'route' => 'exam-results.college',
            'report_module' => 'exam_college',
            'class_options' => ['Certificate', 'Diploma', 'Advanced Diploma', 'Bachelor'],
            'exam_options' => ['Midterm - March', 'Midterm - September', 'Terminal', 'Annual'],
            'uses_gpa' => true,
        ],
        'university' => [
            'title' => 'University Exam Results',
            'route' => 'exam-results.university',
            'report_module' => 'exam_university',
            'class_options' => ['Year 1', 'Year 2', 'Year 3', 'Year 4', 'Year 5'],
            'exam_options' => ['Midterm - March', 'Midterm - September', 'Terminal', 'Annual'],
            'uses_gpa' => true,
        ],
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): View
    {
        $section = $this->resolveSection($request);
        $user = Auth::user();

        $examResults = ExamResult::with('user')
            ->where('education_level', $section['key'])
            ->when($user->role !== 'admin', fn ($query) => $query->where('user_id', $user->id))
            ->latest()
            ->paginate(15);

        return view('exam-results.index', [
            'section' => $section,
            'examResults' => $examResults,
        ]);
    }

    public function create(Request $request): View
    {
        $section = $this->resolveSection($request);

        return view('exam-results.create', [
            'section' => $section,
            'examResult' => new ExamResult(['education_level' => $section['key']]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $section = $this->resolveSection($request);
        $validated = $this->validateData($request, $section);
        $validated['education_level'] = $section['key'];
        $validated['user_id'] = Auth::id();

        $examResult = ExamResult::create($validated);

        return redirect()
            ->route($section['route'] . '.show', $examResult)
            ->with('success', 'Exam results were saved successfully.');
    }

    public function show(Request $request, ExamResult $examResult): View
    {
        $section = $this->resolveSection($request);
        $this->authorizeExamResult($examResult, $section['key']);
        $examResult->load('user');

        return view('exam-results.show', compact('section', 'examResult'));
    }

    public function edit(Request $request, ExamResult $examResult): View
    {
        $section = $this->resolveSection($request);
        $this->authorizeExamResult($examResult, $section['key']);

        return view('exam-results.edit', compact('section', 'examResult'));
    }

    public function update(Request $request, ExamResult $examResult): RedirectResponse
    {
        $section = $this->resolveSection($request);
        $this->authorizeExamResult($examResult, $section['key']);

        $validated = $this->validateData($request, $section);
        $examResult->update($validated);

        return redirect()
            ->route($section['route'] . '.show', $examResult)
            ->with('success', 'Exam results were updated successfully.');
    }

    public function destroy(Request $request, ExamResult $examResult): RedirectResponse
    {
        $section = $this->resolveSection($request);
        $this->authorizeExamResult($examResult, $section['key']);
        $examResult->delete();

        return redirect()
            ->route($section['route'] . '.index')
            ->with('success', 'Exam result record was deleted successfully.');
    }

    protected function validateData(Request $request, array $section): array
    {
        $rules = [
            'student_name' => ['required', 'string', 'max:255'],
            'school_name' => ['required', 'string', 'max:255'],
            'class_level' => ['required', 'string', 'max:255'],
            'exam_type' => ['required', 'string', 'max:255'],
            'exam_year' => ['required', 'integer', 'between:2000,2100'],
            'best_subjects' => ['nullable', 'string'],
            'failed_subjects' => ['nullable', 'string'],
            'comments' => ['nullable', 'string'],
        ];

        if ($section['uses_gpa']) {
            $rules['gpa'] = ['required', 'string', 'max:50'];
            $rules['performance'] = ['nullable', 'string', 'max:255'];
        } else {
            $rules['performance'] = ['required', 'string', 'in:Excellent,Good,Average,Poor'];
            $rules['gpa'] = ['nullable', 'string', 'max:50'];
        }

        return $request->validate($rules);
    }

    protected function authorizeExamResult(ExamResult $examResult, string $sectionKey): void
    {
        $user = Auth::user();

        if ($examResult->education_level !== $sectionKey) {
            throw new NotFoundHttpException('Exam result not found in this section.');
        }

        if ($user->role !== 'admin' && (int) $examResult->user_id !== (int) $user->id) {
            abort(403, 'You are not allowed to view another user\'s record.');
        }
    }

    protected function resolveSection(Request $request): array
    {
        $key = $request->route('sectionKey');

        if (! isset($this->sections[$key])) {
            throw new NotFoundHttpException('Exam results section not found.');
        }

        return array_merge($this->sections[$key], ['key' => $key]);
    }
}
