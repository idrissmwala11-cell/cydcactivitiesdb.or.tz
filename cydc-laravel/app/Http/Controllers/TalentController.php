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
        $talents = TalentsInformation::with('user')
            ->when(Auth::user()->role !== 'admin', function ($query) {
                return $query->where('user_id', Auth::id());
            })
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

        $talent = TalentsInformation::create($validated);

        return redirect()->route('talents.index')
            ->with('success', 'Talent information created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TalentsInformation $talent): View
    {
        $this->authorize('view', $talent);
        return view('talents.show', compact('talent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TalentsInformation $talent): View
    {
        $this->authorize('update', $talent);
        return view('talents.edit', compact('talent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TalentsInformation $talent): RedirectResponse
    {
        $this->authorize('update', $talent);

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

        return redirect()->route('talents.index')
            ->with('success', 'Talent information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TalentsInformation $talent): RedirectResponse
    {
        $this->authorize('delete', $talent);
        
        $talent->delete();

        return redirect()->route('talents.index')
            ->with('success', 'Talent information deleted successfully.');
    }
}
