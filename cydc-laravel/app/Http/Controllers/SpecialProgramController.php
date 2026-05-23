<?php

namespace App\Http\Controllers;

use App\Models\SpecialProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpecialProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specialPrograms = SpecialProgram::with('user')->paginate(15);
        return view('special-programs.index', compact('specialPrograms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('special-programs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'teacher' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'age_range' => 'required|string|max:255',
            'teacher_feedback' => 'nullable|string',
            'supervisor_feedback' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        
        SpecialProgram::create($validated);
        
        return redirect()->route('special-programs.index')
            ->with('success', 'Special program created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SpecialProgram $specialProgram)
    {
        return view('special-programs.show', compact('specialProgram'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SpecialProgram $specialProgram)
    {
        return view('special-programs.edit', compact('specialProgram'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SpecialProgram $specialProgram)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'teacher' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'age_range' => 'required|string|max:255',
            'teacher_feedback' => 'nullable|string',
            'supervisor_feedback' => 'nullable|string',
        ]);
        
        $specialProgram->update($validated);
        
        return redirect()->route('special-programs.index')
            ->with('success', 'Special program updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SpecialProgram $specialProgram)
    {
        $specialProgram->delete();
        
        return redirect()->route('special-programs.index')
            ->with('success', 'Special program deleted successfully.');
    }
}
