<?php

namespace App\Http\Controllers;

use App\Models\FormTwoAssessment;
use App\Models\FormTwoMark;
use App\Models\FormTwoStudent;
use App\Models\FormTwoSubject;
use App\Services\FormTwoResultCalculator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FormTwoResultsController extends Controller
{
    public function __construct(private readonly FormTwoResultCalculator $calculator)
    {
    }

    public function index(Request $request): View
    {
        $selection = $this->selection($request);
        $latestAssessment = $this->assessmentQuery($selection)->orderByDesc('display_order')->first();

        return view('form-two-results.index', [
            'studentCount' => $this->studentQuery($selection)->where('is_active', true)->count(),
            'subjectCount' => FormTwoSubject::where('is_active', true)->where('education_level', $selection['education_level'])->count(),
            'assessmentCount' => $this->assessmentQuery($selection)->count(),
            'markCount' => FormTwoMark::whereHas('assessment', fn ($query) => $this->applySelection($query, $selection))->count(),
            'latestAssessment' => $latestAssessment,
            ...$selection,
        ]);
    }

    public function subjects(Request $request): View
    {
        $selection = $this->selection($request);

        return view('form-two-results.subjects', [
            'subjects' => FormTwoSubject::where('education_level', $selection['education_level'])->orderBy('display_order')->get(),
            ...$selection,
        ]);
    }

    public function updateSubjects(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subjects' => ['required', 'array'],
            'subjects.*.code' => ['required', 'string', 'max:10'],
            'subjects.*.name' => ['required', 'string', 'max:255'],
            'subjects.*.abbreviation' => ['required', 'string', 'max:20'],
            'subjects.*.display_order' => ['required', 'integer', 'min:0'],
            'subjects.*.is_active' => ['nullable', 'boolean'],
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['subjects'] as $id => $data) {
                $subject = FormTwoSubject::findOrFail($id);
                $subject->update([
                    ...$data,
                    'is_active' => (bool) ($data['is_active'] ?? false),
                ]);
            }
        });

        return back()->with('success', 'Masomo na codes zimehifadhiwa.');
    }

    public function students(Request $request): View
    {
        $selection = $this->selection($request);

        return view('form-two-results.students.index', [
            'students' => $this->studentQuery($selection)->with('subjects')->orderBy('student_number')->paginate(30)->withQueryString(),
            'subjects' => FormTwoSubject::where('is_active', true)->where('education_level', $selection['education_level'])->orderBy('display_order')->get(),
            ...$selection,
        ]);
    }

    public function storeStudent(Request $request): RedirectResponse
    {
        $validated = $this->validateStudent($request);
        $subjectIds = $validated['subject_ids'];
        unset($validated['subject_ids']);

        DB::transaction(function () use ($validated, $subjectIds, $request) {
            $nextNumber = ((int) FormTwoStudent::max('id')) + 1;
            $classCode = config('form_two_results.class_codes.'.$validated['class_level'], preg_replace('/\D/', '', $validated['class_level']));
            $prefix = ($validated['education_level'] === 'primary' ? 'P' : 'F').$classCode;
            $student = FormTwoStudent::create([
                ...$validated,
                'student_number' => $validated['student_number'] ?: $prefix.'-'.str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT),
                'created_by' => $request->user()->id,
            ]);
            $student->subjects()->sync($this->subjectSyncData($subjectIds));
        });

        return redirect()->route('form-two-results.students.index', [
            'education_level' => $validated['education_level'],
            'class_level' => $validated['class_level'],
        ])->with('success', 'Mwanafunzi ameongezwa kwenye darasa lililochaguliwa.');
    }

    public function editStudent(FormTwoStudent $student): View
    {
        $student->load('subjects');

        return view('form-two-results.students.edit', [
            'student' => $student,
            'subjects' => FormTwoSubject::where('education_level', $student->education_level)->orderBy('display_order')->get(),
            'educationLevel' => $student->education_level,
            'classLevel' => $student->class_level,
            'classOptions' => config('form_two_results.classes'),
        ]);
    }

    public function updateStudent(Request $request, FormTwoStudent $student): RedirectResponse
    {
        $validated = $this->validateStudent($request, $student);
        $subjectIds = $validated['subject_ids'];
        unset($validated['subject_ids']);

        DB::transaction(function () use ($validated, $subjectIds, $student) {
            $student->update($validated);
            $student->subjects()->sync($this->subjectSyncData($subjectIds));
        });

        return redirect()->route('form-two-results.students.index', [
            'education_level' => $validated['education_level'],
            'class_level' => $validated['class_level'],
        ])->with('success', 'Taarifa za mwanafunzi zimebadilishwa.');
    }

    public function destroyStudent(FormTwoStudent $student): RedirectResponse
    {
        $student->delete();

        return back()->with('success', 'Rekodi ya mwanafunzi imefutwa.');
    }

    public function assessments(Request $request): View
    {
        $selection = $this->selection($request);

        return view('form-two-results.assessments', [
            'assessments' => $this->assessmentQuery($selection)->orderBy('display_order')->get(),
            ...$selection,
        ]);
    }

    public function storeAssessment(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'term' => ['required', 'string', 'max:20'],
            'assessment_date' => ['nullable', 'date'],
            'max_marks' => ['required', 'numeric', 'min:1', 'max:1000'],
            'display_order' => ['required', 'integer', 'min:0'],
            'education_level' => ['required', Rule::in(array_keys(config('form_two_results.classes')))],
            'class_level' => ['required', 'string', 'max:30'],
        ]);

        abort_unless(in_array($validated['class_level'], config("form_two_results.classes.{$validated['education_level']}", []), true), 422, 'Darasa halilingani na ngazi iliyochaguliwa.');
        $validated['max_marks'] = $validated['education_level'] === 'primary' ? 50 : 100;

        $baseSlug = Str::slug($validated['education_level'].'-'.$validated['class_level'].'-'.$validated['name']);
        $slug = $baseSlug;
        $suffix = 2;
        while (FormTwoAssessment::where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$suffix++;
        }

        FormTwoAssessment::create([...$validated, 'slug' => $slug]);

        return redirect()->route('form-two-results.assessments.index', [
            'education_level' => $validated['education_level'],
            'class_level' => $validated['class_level'],
        ])->with('success', 'Kipindi cha mtihani kimeongezwa.');
    }

    public function updateAssessment(Request $request, FormTwoAssessment $assessment): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'term' => ['required', 'string', 'max:20'],
            'assessment_date' => ['nullable', 'date'],
            'max_marks' => ['required', 'numeric', 'min:1', 'max:1000'],
            'display_order' => ['required', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
            'education_level' => ['required', Rule::in(array_keys(config('form_two_results.classes')))],
            'class_level' => ['required', 'string', 'max:30'],
        ]);

        abort_unless(in_array($validated['class_level'], config("form_two_results.classes.{$validated['education_level']}", []), true), 422, 'Darasa halilingani na ngazi iliyochaguliwa.');
        $validated['max_marks'] = $validated['education_level'] === 'primary' ? 50 : 100;

        $assessment->update([
            ...$validated,
            'is_published' => (bool) ($validated['is_published'] ?? false),
        ]);

        return redirect()->route('form-two-results.assessments.index', [
            'education_level' => $validated['education_level'],
            'class_level' => $validated['class_level'],
        ])->with('success', 'Kipindi cha mtihani kimehifadhiwa.');
    }

    public function destroyAssessment(FormTwoAssessment $assessment): RedirectResponse
    {
        $assessment->delete();

        return back()->with('success', 'Kipindi cha mtihani kimefutwa.');
    }

    public function marks(Request $request): View
    {
        $assessment = $this->selectedAssessment($request);
        $selection = $this->selection($request, $assessment);
        $students = $this->studentQuery($selection)->where('is_active', true)
            ->with(['subjects' => fn ($query) => $query->where('form_two_subjects.is_active', true), 'marks' => function ($query) use ($assessment) {
                if ($assessment) {
                    $query->where('assessment_id', $assessment->id);
                }
            }])
            ->orderBy('student_number')
            ->get();

        return view('form-two-results.marks', [
            'assessments' => $this->assessmentQuery($selection)->orderBy('display_order')->get(),
            'assessment' => $assessment,
            'students' => $students,
            'subjects' => FormTwoSubject::where('is_active', true)->where('education_level', $selection['education_level'])->orderBy('display_order')->get(),
            ...$selection,
        ]);
    }

    public function storeMarks(Request $request, FormTwoAssessment $assessment): RedirectResponse
    {
        $payload = json_decode((string) $request->input('marks_payload'), true);
        $validated = validator(['marks' => $payload], [
            'marks' => ['required', 'array', 'max:5000'],
            'marks.*.student_id' => ['required', 'integer', 'exists:form_two_students,id'],
            'marks.*.subject_id' => ['required', 'integer', 'exists:form_two_subjects,id'],
            'marks.*.mark' => ['nullable', 'numeric', 'min:0', 'max:'.$assessment->max_marks],
            'marks.*.is_absent' => ['required', 'boolean'],
        ])->validate();

        $allowedStudentIds = $this->studentQuery([
            'education_level' => $assessment->education_level,
            'class_level' => $assessment->class_level,
        ])->pluck('id');

        $allowedPairs = DB::table('form_two_student_subject')
            ->where('registered', true)
            ->whereIn('student_id', $allowedStudentIds)
            ->get(['student_id', 'subject_id'])
            ->mapWithKeys(fn ($row) => [$row->student_id.':'.$row->subject_id => true]);

        DB::transaction(function () use ($validated, $assessment, $allowedPairs, $request) {
            foreach ($validated['marks'] as $item) {
                abort_unless($allowedPairs->has($item['student_id'].':'.$item['subject_id']), 422, 'Somo halijasajiliwa kwa mwanafunzi huyu.');

                $isAbsent = (bool) $item['is_absent'];
                $mark = $isAbsent ? null : ($item['mark'] === null || $item['mark'] === '' ? null : $item['mark']);
                $keys = [
                    'assessment_id' => $assessment->id,
                    'student_id' => $item['student_id'],
                    'subject_id' => $item['subject_id'],
                ];

                if ($mark === null && ! $isAbsent) {
                    FormTwoMark::where($keys)->delete();
                    continue;
                }

                FormTwoMark::updateOrCreate($keys, [
                    'mark' => $mark,
                    'is_absent' => $isAbsent,
                    'recorded_by' => $request->user()->id,
                ]);
            }
        });

        return redirect()->route('form-two-results.marks.index', [
            'assessment_id' => $assessment->id,
            'education_level' => $assessment->education_level,
            'class_level' => $assessment->class_level,
        ])
            ->with('success', 'Alama zimehifadhiwa na matokeo yamekokotolewa.');
    }

    public function results(Request $request): View
    {
        $assessment = $this->selectedAssessment($request);
        $selection = $this->selection($request, $assessment);
        $rows = $assessment ? $this->resultRows($assessment) : collect();
        $subjectQuery = FormTwoSubject::where('education_level', $selection['education_level'])
            ->where('is_active', true);

        if ($selection['education_level'] === 'secondary') {
            $registeredSubjectIds = $rows
                ->flatMap(fn ($row) => collect($row['subjects'])->pluck('subject.id'))
                ->unique()
                ->values();
            $subjectQuery->whereIn('id', $registeredSubjectIds);
        }

        return view('form-two-results.results', [
            'assessments' => $this->assessmentQuery($selection)->orderBy('display_order')->get(),
            'assessment' => $assessment,
            'subjects' => $subjectQuery->orderBy('display_order')->get(),
            'rows' => $rows,
            'groups' => $this->performanceGroups($rows, $selection['education_level'] === 'primary'),
            ...$selection,
        ]);
    }

    public function analysis(Request $request): View
    {
        $assessment = $this->selectedAssessment($request);
        $selection = $this->selection($request, $assessment);
        $rows = $assessment ? $this->resultRows($assessment) : collect();
        $groups = $this->performanceGroups($rows, $selection['education_level'] === 'primary');

        $subjectAnalysis = collect();
        if ($assessment) {
            $subjectAnalysis = FormTwoSubject::where('is_active', true)->where('education_level', $selection['education_level'])->orderBy('display_order')->get()->map(function ($subject) use ($rows, $assessment) {
                $entries = $rows->flatMap(fn ($row) => collect($row['subjects'])->where('subject.id', $subject->id));
                $marks = $entries->pluck('mark')->filter(fn ($mark) => $mark !== null);
                $passed = $marks->filter(fn ($mark) => in_array($this->calculator->grade((float) $mark, (float) $assessment->max_marks), ['A', 'B', 'C', 'D'], true))->count();

                return [
                    'subject' => $subject,
                    'sat' => $marks->count(),
                    'average' => $marks->count() ? round($marks->average(), 2) : null,
                    'passed' => $passed,
                    'pass_rate' => $marks->count() ? round(($passed / $marks->count()) * 100, 1) : 0,
                ];
            });
        }

        return view('form-two-results.analysis', compact('assessment', 'rows', 'groups', 'subjectAnalysis') + [
            'assessments' => $this->assessmentQuery($selection)->orderBy('display_order')->get(),
            ...$selection,
        ]);
    }

    private function performanceGroups(Collection $rows, bool $isPrimary): Collection
    {
        return collect(['F', 'M', 'ALL'])->mapWithKeys(function ($sex) use ($rows, $isPrimary) {
            $groupRows = $sex === 'ALL' ? $rows : $rows->filter(fn ($row) => $row['student']->sex === $sex);
            $sat = $groupRows->whereNotNull('average')->count();
            $passed = $isPrimary
                ? $groupRows->whereIn('overall_grade', ['A', 'B', 'C', 'D'])->count()
                : $groupRows->whereIn('division', ['I', 'II', 'III', 'IV'])->count();

            return [$sex => [
                'registered' => $groupRows->count(),
                'sat' => $sat,
                'absent' => $groupRows->whereNull('average')->count(),
                'divisions' => collect(['I', 'II', 'III', 'IV', '0', 'INC'])->mapWithKeys(
                    fn ($division) => [$division => $groupRows->where('division', $division)->count()]
                ),
                'grades' => collect(['A', 'B', 'C', 'D', 'F'])->mapWithKeys(
                    fn ($grade) => [$grade => $groupRows->where('overall_grade', $grade)->count()]
                ),
                'passed' => $passed,
                'pass_rate' => $sat ? round(($passed / $sat) * 100, 1) : 0,
            ]];
        });
    }

    public function report(Request $request, FormTwoStudent $student): View
    {
        $assessment = $this->selectedAssessment($request);
        abort_unless($assessment, 404, 'Hakuna kipindi cha mtihani.');
        abort_unless($student->education_level === $assessment->education_level && $student->class_level === $assessment->class_level, 404);

        $rows = $this->resultRows($assessment);
        $summary = $rows->first(fn ($row) => $row['student']->is($student));
        abort_unless($summary, 404);

        return view('form-two-results.report', [
            'assessment' => $assessment,
            'summary' => $summary,
        ]);
    }

    private function validateStudent(Request $request, ?FormTwoStudent $student = null): array
    {
        $validated = $request->validate([
            'student_number' => ['nullable', 'string', 'max:30', Rule::unique('form_two_students')->ignore($student)],
            'candidate_name' => ['required', 'string', 'max:255'],
            'fcp_name' => ['nullable', 'string', 'max:255'],
            'sex' => ['required', Rule::in(['F', 'M'])],
            'education_level' => ['required', Rule::in(array_keys(config('form_two_results.classes')))],
            'class_level' => ['required', 'string', 'max:30'],
            'is_active' => ['nullable', 'boolean'],
            'subject_ids' => ['required', 'array', 'min:1'],
            'subject_ids.*' => ['integer', 'exists:form_two_subjects,id'],
        ]);

        abort_unless(in_array($validated['class_level'], config("form_two_results.classes.{$validated['education_level']}", []), true), 422, 'Darasa halilingani na ngazi iliyochaguliwa.');

        $validSubjectCount = FormTwoSubject::whereIn('id', $validated['subject_ids'])
            ->where('education_level', $validated['education_level'])
            ->count();
        abort_unless($validSubjectCount === count(array_unique($validated['subject_ids'])), 422, 'Masomo hayalingani na ngazi iliyochaguliwa.');

        return $validated;
    }

    private function subjectSyncData(array $subjectIds): array
    {
        return collect($subjectIds)->mapWithKeys(fn ($id) => [$id => ['registered' => true]])->all();
    }

    private function selectedAssessment(Request $request): ?FormTwoAssessment
    {
        if ($request->filled('assessment_id')) {
            return FormTwoAssessment::findOrFail($request->integer('assessment_id'));
        }

        return $this->assessmentQuery($this->selection($request))->orderByDesc('display_order')->first();
    }

    private function resultRows(FormTwoAssessment $assessment): Collection
    {
        $students = FormTwoStudent::where('is_active', true)
            ->where('education_level', $assessment->education_level)
            ->where('class_level', $assessment->class_level)
            ->with([
                'subjects' => fn ($query) => $query->where('form_two_subjects.is_active', true),
                'marks' => fn ($query) => $query->where('assessment_id', $assessment->id),
            ])
            ->orderBy('student_number')
            ->get();

        $rows = $students->map(fn ($student) => $this->calculator->summary($student, $assessment));
        $rankMap = [];
        $previousAverage = null;
        $previousRank = null;

        foreach ($rows->filter(fn ($row) => $row['average'] !== null)->sortByDesc('average')->values() as $index => $row) {
            $rank = $previousAverage !== null && (float) $row['average'] === (float) $previousAverage
                ? $previousRank
                : $index + 1;
            $rankMap[$row['student']->id] = $rank;
            $previousAverage = $row['average'];
            $previousRank = $rank;
        }

        return $rows->map(function ($row) use ($rankMap) {
            $row['rank'] = $rankMap[$row['student']->id] ?? null;

            return $row;
        });
    }

    private function selection(Request $request, ?FormTwoAssessment $assessment = null): array
    {
        $classOptions = config('form_two_results.classes');
        $educationLevel = $assessment?->education_level ?: $request->string('education_level')->toString();
        $educationLevel = array_key_exists($educationLevel, $classOptions) ? $educationLevel : 'secondary';
        $availableClasses = $classOptions[$educationLevel];
        $classLevel = $assessment?->class_level ?: $request->string('class_level')->toString();

        if (! in_array($classLevel, $availableClasses, true)) {
            $classLevel = $educationLevel === 'secondary' ? 'Form 2' : $availableClasses[0];
        }

        return [
            'educationLevel' => $educationLevel,
            'classLevel' => $classLevel,
            'education_level' => $educationLevel,
            'class_level' => $classLevel,
            'classOptions' => $classOptions,
        ];
    }

    private function studentQuery(array $selection)
    {
        return FormTwoStudent::query()
            ->where('education_level', $selection['education_level'])
            ->where('class_level', $selection['class_level']);
    }

    private function assessmentQuery(array $selection)
    {
        return FormTwoAssessment::query()
            ->where('education_level', $selection['education_level'])
            ->where('class_level', $selection['class_level']);
    }

    private function applySelection($query, array $selection)
    {
        return $query
            ->where('education_level', $selection['education_level'])
            ->where('class_level', $selection['class_level']);
    }
}
