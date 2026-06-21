<?php

namespace App\Http\Controllers;

use App\Models\TalentsInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TalentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $user = Auth::user();

        $talents = $this->scopeRecordsVisibleToUser(TalentsInformation::with('user'), $user)
            ->latest()
            ->paginate(10);

        return view('talents.index', compact('talents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('talents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'participant_number' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:100',
            'gender' => 'required|in:Male,Female',
            'mentor' => 'nullable|string|max:255',
            'talent_type' => 'required|string|max:255',
            'talent_description' => 'required|string',
            'talent_duration' => 'required|string|max:255',
            'has_competed' => 'nullable',
            'competition_details' => 'nullable|string',
            'achievements' => 'nullable|string',
            'needs_training' => 'nullable',
            'training_details' => 'nullable|string',
            'comments' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['has_competed'] = $request->has('has_competed');
        $validated['needs_training'] = $request->has('needs_training');

        TalentsInformation::create($validated);

        return redirect()->route('talents.index')
            ->with('success', 'Talent information created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TalentsInformation $talent): View
    {
        $this->authorizeUser($talent);

        $talent->load('user');

        return view('talents.show', compact('talent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TalentsInformation $talent): View
    {
        $this->authorizeUser($talent);

        return view('talents.edit', compact('talent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TalentsInformation $talent): RedirectResponse
    {
        $this->authorizeUser($talent);

        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'participant_number' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:100',
            'gender' => 'required|in:Male,Female',
            'mentor' => 'nullable|string|max:255',
            'talent_type' => 'required|string|max:255',
            'talent_description' => 'required|string',
            'talent_duration' => 'required|string|max:255',
            'has_competed' => 'nullable',
            'competition_details' => 'nullable|string',
            'achievements' => 'nullable|string',
            'needs_training' => 'nullable',
            'training_details' => 'nullable|string',
            'comments' => 'nullable|string',
        ]);

        $validated['has_competed'] = $request->has('has_competed');
        $validated['needs_training'] = $request->has('needs_training');

        $talent->update($validated);

        return redirect()->route('talents.show', $talent->id)
            ->with('success', 'Talent information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TalentsInformation $talent): RedirectResponse
    {
        $this->authorizeUser($talent);

        $talent->delete();

        return redirect()->route('talents.index')
            ->with('success', 'Talent information deleted successfully.');
    }

    /**
     * Hakikisha user anaona record yake tu isipokuwa admin
     */
    protected function authorizeUser(TalentsInformation $talent): void
    {
        $this->authorizeCenterRecord($talent, 'Huruhusiwi kuona taarifa za center nyingine.');
    }
}
