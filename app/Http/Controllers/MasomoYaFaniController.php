<?php

namespace App\Http\Controllers;

use App\Models\MasomoYaFani;
use App\Support\ProgramDayAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasomoYaFaniController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $faniRecords = $this->scopeRecordsVisibleToUser(MasomoYaFani::with('user'), $user)
            ->latest('date')
            ->paginate(15);

        return view('submissions.masomo-ya-fani', compact('faniRecords'));
    }

    public function create()
    {
        $existingSubmission = MasomoYaFani::where('user_id', Auth::id())
            ->where('status', 'draft')
            ->latest('id')
            ->first();

        return view('submissions.masomo-ya-fani-create', compact('existingSubmission'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'teacher' => 'required|string|max:255',
            'fani_type' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'student_preferences' => 'nullable|string',
            'student_feedback' => 'nullable|string',
            'teacher_feedback' => 'nullable|string',
            'participant_roster_text' => 'nullable|string',
            'attendance_marker' => 'nullable|string',
            'present_participant_numbers' => 'nullable|array',
            'present_participant_numbers.*' => 'nullable|string',
            'status' => 'required|in:draft,submitted',
        ]);

        $data = [
            'date' => $validated['date'],
            'teacher' => $validated['teacher'],
            'fani_type' => $validated['fani_type'],
            'topic' => $validated['topic'],
            'student_preferences' => $validated['student_preferences'] ?? null,
            'student_feedback' => $validated['student_feedback'] ?? null,
            'teacher_feedback' => $validated['teacher_feedback'] ?? null,
            'status' => $validated['status'],
            'user_id' => Auth::id(),
        ] + ProgramDayAttendance::fromRequest($request, Auth::id());

        MasomoYaFani::create($data);

        return redirect()->route('submissions.masomo-ya-fani.index')
            ->with('success', 'Masomo ya Fani saved successfully.');
    }

    public function show(MasomoYaFani $masomoYaFani)
    {
        $this->authorizeRecord($masomoYaFani);

        return view('masomo-ya-fani.show', compact('masomoYaFani'));
    }

    public function edit(MasomoYaFani $masomoYaFani)
    {
        $this->authorizeRecord($masomoYaFani);

        return view('masomo-ya-fani.edit', compact('masomoYaFani'));
    }

    public function update(Request $request, MasomoYaFani $masomoYaFani)
    {
        $this->authorizeRecord($masomoYaFani);

        $validated = $request->validate([
            'date' => 'required|date',
            'teacher' => 'required|string|max:255',
            'fani_type' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'student_preferences' => 'nullable|string',
            'student_feedback' => 'nullable|string',
            'teacher_feedback' => 'nullable|string',
            'participant_roster_text' => 'nullable|string',
            'attendance_marker' => 'nullable|string',
            'present_participant_numbers' => 'nullable|array',
            'present_participant_numbers.*' => 'nullable|string',
            'status' => 'required|in:draft,submitted,approved,rejected',
        ]);

        $data = [
            'date' => $validated['date'],
            'teacher' => $validated['teacher'],
            'fani_type' => $validated['fani_type'],
            'topic' => $validated['topic'],
            'student_preferences' => $validated['student_preferences'] ?? null,
            'student_feedback' => $validated['student_feedback'] ?? null,
            'teacher_feedback' => $validated['teacher_feedback'] ?? null,
            'status' => $validated['status'],
        ] + ProgramDayAttendance::fromRequest($request, (int) $masomoYaFani->user_id);

        $masomoYaFani->update($data);

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.masomo-ya-fani.index')
                ->with('success', 'Masomo ya Fani updated successfully.');
        }

        return redirect()->route('submissions.masomo-ya-fani.index')
            ->with('success', 'Masomo ya Fani updated successfully.');
    }

    public function destroy(MasomoYaFani $masomoYaFani)
    {
        $this->authorizeRecord($masomoYaFani);

        $masomoYaFani->delete();

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.masomo-ya-fani.index')
                ->with('success', 'Masomo ya Fani deleted successfully.');
        }

        return redirect()->route('submissions.masomo-ya-fani.index')
            ->with('success', 'Masomo ya Fani deleted successfully.');
    }

    private function authorizeRecord(MasomoYaFani $masomoYaFani): void
    {
        $this->authorizeCenterRecord($masomoYaFani);
    }
}
