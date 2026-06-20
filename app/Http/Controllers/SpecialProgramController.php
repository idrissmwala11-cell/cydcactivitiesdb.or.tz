<?php

namespace App\Http\Controllers;

use App\Models\SpecialProgram;
use App\Support\ProgramDayAttendance;
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
            'participant_roster_text' => 'nullable|string',
            'attendance_marker' => 'nullable|string',
            'present_participant_numbers' => 'nullable|array',
            'present_participant_numbers.*' => 'nullable|string',
        ]);

        $data = [
            'date' => $validated['date'],
            'teacher' => $validated['teacher'],
            'topic' => $validated['topic'],
            'age_range' => $validated['age_range'],
            'teacher_feedback' => $validated['teacher_feedback'] ?? null,
            'supervisor_feedback' => $validated['supervisor_feedback'] ?? null,
            'user_id' => Auth::id(),
        ] + ProgramDayAttendance::fromRequest($request, Auth::id());

        SpecialProgram::create($data);

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
            'participant_roster_text' => 'nullable|string',
            'attendance_marker' => 'nullable|string',
            'present_participant_numbers' => 'nullable|array',
            'present_participant_numbers.*' => 'nullable|string',
        ]);

        $data = [
            'date' => $validated['date'],
            'teacher' => $validated['teacher'],
            'topic' => $validated['topic'],
            'age_range' => $validated['age_range'],
            'teacher_feedback' => $validated['teacher_feedback'] ?? null,
            'supervisor_feedback' => $validated['supervisor_feedback'] ?? null,
        ] + ProgramDayAttendance::fromRequest($request, (int) $special_program->user_id);

        $special_program->update($data);

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
