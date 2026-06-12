<?php

namespace App\Http\Controllers;

use App\Models\SpecialProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpecialProgramController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $specialPrograms = SpecialProgram::with('user')
                ->latest()
                ->paginate(15);
        } else {
            $specialPrograms = SpecialProgram::with('user')
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(15);
        }

        return view('special-programs.index', compact('specialPrograms'));
    }

    public function create()
    {
        return view('special-programs.create');
    }

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

        return redirect()->route('submissions.special-program.index')
            ->with('success', 'Special Program saved successfully.');
    }

    public function show(SpecialProgram $special_program)
    {
    

        $user = Auth::user();

        if ($user->role !== 'admin' && $special_program->user_id != $user->id) {
            abort(403);
        }

        return view('special-programs.show', ['specialProgram' => $special_program]);
    }

    public function edit(SpecialProgram $special_program)
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $special_program->user_id !== $user->id) {
            abort(403);
        }

        return view('special-programs.edit', ['specialProgram' => $special_program]);
    }

    public function update(Request $request, SpecialProgram $special_program)
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $special_program->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'date' => 'required|date',
            'teacher' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'age_range' => 'required|string|max:255',
            'teacher_feedback' => 'nullable|string',
            'supervisor_feedback' => 'nullable|string',
        ]);

        $special_program->update($validated);

        return redirect()->route('submissions.special-program.index')
            ->with('success', 'Special Program updated successfully.');
    }

    public function destroy(SpecialProgram $special_program)
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $special_program->user_id !== $user->id) {
            abort(403);
        }

        $special_program->delete();

        return redirect()->route('submissions.special-program.index')
            ->with('success', 'Special Program deleted successfully.');
    }
}