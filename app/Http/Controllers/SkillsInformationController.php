<?php

namespace App\Http\Controllers;

use App\Models\SkillsInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillsInformationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $skillsInformation = $this->scopeRecordsVisibleToUser(SkillsInformation::with('user'), $user)
            ->latest()
            ->paginate(15);

        return view('skills-information.index', compact('skillsInformation'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('skills-information.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        $validated['user_id'] = Auth::id();

        SkillsInformation::create($validated);

        return redirect()
            ->route('skills-information.index')
            ->with('success', 'Skills information created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SkillsInformation $skillsInformation)
    {
        $this->authorizeUser($skillsInformation);

        $skillsInformation->load('user');

        return view('skills-information.show', compact('skillsInformation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SkillsInformation $skillsInformation)
    {
        $this->authorizeUser($skillsInformation);

        return view('skills-information.edit', compact('skillsInformation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SkillsInformation $skillsInformation)
    {
        $this->authorizeUser($skillsInformation);

        $validated = $this->validateData($request);

        $skillsInformation->update($validated);

        return redirect()
            ->route('skills-information.show', $skillsInformation->id)
            ->with('success', 'Skills information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SkillsInformation $skillsInformation)
    {
        $this->authorizeUser($skillsInformation);

        $skillsInformation->delete();

        return redirect()
            ->route('skills-information.index')
            ->with('success', 'Skills information deleted successfully.');
    }

    /**
     * Validate request data
     */
    protected function validateData(Request $request): array
    {
        return $request->validate([
            'student_name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'student_id' => 'required|string|max:255',
            'skill_category' => 'required|string|max:255',
            'specific_skills' => 'required|string',
            'skills_type' => 'required|string|max:255',
            'group_skills_details' => 'nullable|string',
            'skill_level' => 'required|string|max:255',
            'has_certification' => 'nullable|string|max:255',
            'certification_details' => 'nullable|string',
            'mentor' => 'nullable|string|max:255',
            'challenges' => 'nullable|string',
            'support_received' => 'nullable|string',
            'comments' => 'nullable|string',
        ]);
    }

    /**
     * Hakikisha user anaona/kuhariri record yake mwenyewe tu, isipokuwa admin
     */
    protected function authorizeUser(SkillsInformation $skillsInformation): void
    {
        $this->authorizeCenterRecord($skillsInformation, 'Huruhusiwi kuona taarifa za center nyingine.');
    }
}
