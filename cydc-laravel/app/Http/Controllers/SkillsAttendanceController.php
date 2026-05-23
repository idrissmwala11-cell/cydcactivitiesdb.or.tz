<?php

namespace App\Http\Controllers;

use App\Models\SkillsAttendance;
use App\Models\AbsentParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class SkillsAttendanceController extends Controller
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
        $attendances = SkillsAttendance::with(['user', 'absentParticipants'])
            ->when(Auth::user()->role !== 'admin', function ($query) {
                return $query->where('user_id', Auth::id());
            })
            ->latest('date')
            ->paginate(15);

        return view('skills-attendance.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('skills-attendance.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'teacher_name' => 'required|string|max:255',
            'lesson_topic' => 'required|string|max:255',
            'present_count' => 'required|integer|min:0',
            'teacher_comments' => 'nullable|string',
            'supervisor_comments' => 'nullable|string',
            'lesson_topic_details' => 'nullable|string',
            'absent_participants' => 'nullable|array',
            'absent_participants.*.participant_name' => 'required_with:absent_participants|string|max:255',
            'absent_participants.*.participant_number' => 'required_with:absent_participants|string|max:255',
        ]);

        DB::transaction(function () use ($validated) {
            $validated['user_id'] = Auth::id();
            $absentParticipants = $validated['absent_participants'] ?? [];
            unset($validated['absent_participants']);

            $attendance = SkillsAttendance::create($validated);

            // Create absent participants records
            foreach ($absentParticipants as $participant) {
                if (!empty($participant['participant_name']) && !empty($participant['participant_number'])) {
                    AbsentParticipant::create([
                        'attendance_id' => $attendance->id,
                        'participant_name' => $participant['participant_name'],
                        'participant_number' => $participant['participant_number'],
                        'user_id' => Auth::id(),
                    ]);
                }
            }
        });

        return redirect()->route('skills-attendance.index')
            ->with('success', 'Skills attendance record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SkillsAttendance $skillsAttendance): View
    {
        $this->authorize('view', $skillsAttendance);
        $skillsAttendance->load('absentParticipants');
        return view('skills-attendance.show', compact('skillsAttendance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SkillsAttendance $skillsAttendance): View
    {
        $this->authorize('update', $skillsAttendance);
        $skillsAttendance->load('absentParticipants');
        return view('skills-attendance.edit', compact('skillsAttendance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SkillsAttendance $skillsAttendance): RedirectResponse
    {
        $this->authorize('update', $skillsAttendance);

        $validated = $request->validate([
            'date' => 'required|date',
            'teacher_name' => 'required|string|max:255',
            'lesson_topic' => 'required|string|max:255',
            'present_count' => 'required|integer|min:0',
            'teacher_comments' => 'nullable|string',
            'supervisor_comments' => 'nullable|string',
            'lesson_topic_details' => 'nullable|string',
            'absent_participants' => 'nullable|array',
            'absent_participants.*.participant_name' => 'required_with:absent_participants|string|max:255',
            'absent_participants.*.participant_number' => 'required_with:absent_participants|string|max:255',
        ]);

        DB::transaction(function () use ($validated, $skillsAttendance) {
            $absentParticipants = $validated['absent_participants'] ?? [];
            unset($validated['absent_participants']);

            $skillsAttendance->update($validated);

            // Delete existing absent participants and create new ones
            $skillsAttendance->absentParticipants()->delete();
            
            foreach ($absentParticipants as $participant) {
                if (!empty($participant['participant_name']) && !empty($participant['participant_number'])) {
                    AbsentParticipant::create([
                        'attendance_id' => $skillsAttendance->id,
                        'participant_name' => $participant['participant_name'],
                        'participant_number' => $participant['participant_number'],
                        'user_id' => Auth::id(),
                    ]);
                }
            }
        });

        return redirect()->route('skills-attendance.index')
            ->with('success', 'Skills attendance record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SkillsAttendance $skillsAttendance): RedirectResponse
    {
        $this->authorize('delete', $skillsAttendance);
        
        $skillsAttendance->delete();

        return redirect()->route('skills-attendance.index')
            ->with('success', 'Skills attendance record deleted successfully.');
    }
}
