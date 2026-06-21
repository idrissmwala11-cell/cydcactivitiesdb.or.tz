<?php

namespace App\Http\Controllers;

use App\Models\SchoolVisitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolVisitationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        $schoolVisitations = $this->scopeRecordsVisibleToUser(SchoolVisitation::with('user'), $user)
            ->latest()
            ->paginate(15);

        return view('school-visitation.index', compact('schoolVisitations'));
    }

    public function create()
    {
        return view('school-visitation.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);
        $validated['user_id'] = Auth::id();

        SchoolVisitation::create($validated);

        return redirect()
            ->route('school-visitation.index')
            ->with('success', 'School visitation information was saved successfully.');
    }

    public function show(SchoolVisitation $schoolVisitation)
    {
        $this->authorizeUser($schoolVisitation);
        $schoolVisitation->load('user');

        return view('school-visitation.show', compact('schoolVisitation'));
    }

    public function edit(SchoolVisitation $schoolVisitation)
    {
        $this->authorizeUser($schoolVisitation);

        return view('school-visitation.edit', compact('schoolVisitation'));
    }

    public function update(Request $request, SchoolVisitation $schoolVisitation)
    {
        $this->authorizeUser($schoolVisitation);

        $validated = $this->validateData($request);
        $schoolVisitation->update($validated);

        return redirect()
            ->route('school-visitation.show', $schoolVisitation)
            ->with('success', 'School visitation information was updated successfully.');
    }

    public function destroy(SchoolVisitation $schoolVisitation)
    {
        $this->authorizeUser($schoolVisitation);
        $schoolVisitation->delete();

        return redirect()
            ->route('school-visitation.index')
            ->with('success', 'School visitation record was deleted successfully.');
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'participant_name' => ['required', 'string', 'max:255'],
            'registration_number' => ['required', 'string', 'max:255'],
            'school_name' => ['required', 'string', 'max:255'],
            'class_level' => ['required', 'string', 'max:255'],
            'participant_presence' => ['required', 'string', 'in:Present,Absent'],
            'academic_progress' => ['required', 'string', 'in:Satisfactory,Unsatisfactory'],
            'academic_challenges' => ['nullable', 'string', 'required_if:academic_progress,Unsatisfactory'],
            'discipline_status' => ['required', 'string', 'in:Good,Average,Poor'],
            'bad_behaviors' => ['nullable', 'string', 'required_if:discipline_status,Poor'],
            'cleanliness_status' => ['required', 'string', 'max:255'],
            'teacher_comments' => ['nullable', 'string'],
            'visitor_comments' => ['nullable', 'string'],
        ]);
    }

    protected function authorizeUser(SchoolVisitation $schoolVisitation): void
    {
        $this->authorizeCenterRecord($schoolVisitation, 'Huruhusiwi kuona taarifa za center nyingine.');
    }
}
