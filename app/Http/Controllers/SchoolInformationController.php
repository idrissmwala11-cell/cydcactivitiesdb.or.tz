<?php

namespace App\Http\Controllers;

use App\Models\SchoolInformationRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SchoolInformationController extends Controller
{
    protected array $sections = [
        'primary' => [
            'title' => 'Primary Information',
            'form_view' => 'school-info.primary',
            'route' => 'school-info.primary',
        ],
        'secondary' => [
            'title' => 'Secondary Information',
            'form_view' => 'school-info.secondary',
            'route' => 'school-info.secondary',
        ],
        'a-level' => [
            'title' => 'A Level Information',
            'form_view' => 'school-info.a-level',
            'route' => 'school-info.a-level',
        ],
        'university' => [
            'title' => 'University Information',
            'form_view' => 'school-info.university',
            'route' => 'school-info.university',
        ],
        'college' => [
            'title' => 'College Information',
            'form_view' => 'school-info.college',
            'route' => 'school-info.college',
        ],
        'vocational-training' => [
            'title' => 'Vocational Training Information',
            'form_view' => 'school-info.vocational-training',
            'route' => 'school-info.vocational-training',
        ],
        'others' => [
            'title' => 'Other Educational Information',
            'form_view' => 'school-info.others',
            'route' => 'school-info.others',
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

        $records = SchoolInformationRecord::with('user')
            ->where('education_level', $section['key'])
            ->when($user->role !== 'admin', fn ($query) => $query->where('user_id', $user->id))
            ->latest()
            ->paginate(15);

        return view('school-info.index', compact('section', 'records'));
    }

    public function create(Request $request): View
    {
        $section = $this->resolveSection($request);
        $view = $section['form_view'];

        if (! ViewFacade::exists($view)) {
            Log::error('School information form view missing.', [
                'section' => $section['key'],
                'view' => $view,
                'user_id' => Auth::id(),
            ]);

            abort(404, "View [{$view}] not found.");
        }

        return view($view, [
            'pageTitle' => $section['title'],
            'sectionKey' => $section['key'],
            'sectionName' => $section['title'],
            'sectionRoute' => $section['route'],
            'schoolInformation' => new SchoolInformationRecord(['education_level' => $section['key']]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $section = $this->resolveSection($request);
        $validated = $request->validate([
            'form_data' => ['required', 'array'],
        ]);

        $record = SchoolInformationRecord::create([
            'education_level' => $section['key'],
            'form_data' => $validated['form_data'],
            'user_id' => Auth::id(),
        ]);

        return redirect()
            ->route($section['route'] . '.show', $record)
            ->with('success', 'School information was saved successfully.');
    }

    public function show(Request $request, SchoolInformationRecord $schoolInformationRecord): View
    {
        $section = $this->resolveSection($request);
        $this->authorizeRecord($schoolInformationRecord, $section['key']);
        $schoolInformationRecord->load('user');

        return view('school-info.show', [
            'section' => $section,
            'schoolInformationRecord' => $schoolInformationRecord,
        ]);
    }

    public function edit(Request $request, SchoolInformationRecord $schoolInformationRecord): View
    {
        $section = $this->resolveSection($request);
        $this->authorizeRecord($schoolInformationRecord, $section['key']);

        return view('school-info.edit', [
            'section' => $section,
            'schoolInformationRecord' => $schoolInformationRecord,
        ]);
    }

    public function update(Request $request, SchoolInformationRecord $schoolInformationRecord): RedirectResponse
    {
        $section = $this->resolveSection($request);
        $this->authorizeRecord($schoolInformationRecord, $section['key']);

        $validated = $request->validate([
            'form_data' => ['required', 'array'],
        ]);

        $schoolInformationRecord->update([
            'form_data' => $validated['form_data'],
        ]);

        return redirect()
            ->route($section['route'] . '.show', $schoolInformationRecord)
            ->with('success', 'School information was updated successfully.');
    }

    public function destroy(Request $request, SchoolInformationRecord $schoolInformationRecord): RedirectResponse
    {
        $section = $this->resolveSection($request);
        $this->authorizeRecord($schoolInformationRecord, $section['key']);
        $schoolInformationRecord->delete();

        return redirect()
            ->route($section['route'] . '.index')
            ->with('success', 'School information record was deleted successfully.');
    }

    protected function resolveSection(Request $request): array
    {
        $key = $request->route('sectionKey');

        if (! isset($this->sections[$key])) {
            throw new NotFoundHttpException('School information section not found.');
        }

        return array_merge($this->sections[$key], ['key' => $key]);
    }

    protected function authorizeRecord(SchoolInformationRecord $record, string $sectionKey): void
    {
        $user = Auth::user();

        if ($record->education_level !== $sectionKey) {
            throw new NotFoundHttpException('School information record not found in this section.');
        }

        if ($user->role !== 'admin' && (int) $record->user_id !== (int) $user->id) {
            abort(403, 'You are not allowed to view another user\'s record.');
        }
    }
}
