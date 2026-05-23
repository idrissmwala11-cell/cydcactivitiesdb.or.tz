<?php

namespace App\Http\Controllers;

use App\Models\VocationalTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VocationalTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vocationalTrainings = VocationalTraining::with('user')->paginate(15);
        return view('vocational-training.index', compact('vocationalTrainings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vocational-training.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'school_name' => 'required|string|max:255',
            'skill_category' => 'required|string|max:255',
            'training_level' => 'required|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();
        
        VocationalTraining::create($validated);
        
        return redirect()->route('vocational-training.index')
            ->with('success', 'Vocational training record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(VocationalTraining $vocationalTraining)
    {
        return view('vocational-training.show', compact('vocationalTraining'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VocationalTraining $vocationalTraining)
    {
        return view('vocational-training.edit', compact('vocationalTraining'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VocationalTraining $vocationalTraining)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'school_name' => 'required|string|max:255',
            'skill_category' => 'required|string|max:255',
            'training_level' => 'required|string|max:255',
        ]);
        
        $vocationalTraining->update($validated);
        
        return redirect()->route('vocational-training.index')
            ->with('success', 'Vocational training record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VocationalTraining $vocationalTraining)
    {
        $vocationalTraining->delete();
        
        return redirect()->route('vocational-training.index')
            ->with('success', 'Vocational training record deleted successfully.');
    }
}
