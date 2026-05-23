<?php

namespace App\Http\Controllers;

use App\Models\TalentAttendance;
use App\Models\TalentAbsentParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class TalentAttendanceController extends Controller
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
        $attendances = TalentAttendance::with(['user', 'absentParticipants'])
            ->when(Auth::user()->role !== 'admin', function ($query) {
                return $query->where('user_id', Auth::id());
            })
            ->latest('date')
            ->paginate(10);

        return view('talent-attendance.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('talent-attendance.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'instructor_name' => 'required|string|max:255',
            'talent_taught' => 'required|string|max:255',
            'attendance_count' => 'required|integer|min:0',
            'instructor_comments' => 'nullable|string',
            'supervisor_comments' => 'nullable|string',
            'lesson_topic' => 'required|string|max:255',
            'absent_participants' => 'nullable|array',
            'absent_participants.*.participant_name' => 'required_with:absent_participants|string|max:255',
            'absent_participants.*.participant_number' => 'required_with:absent_participants|string|max:255',
        ]);

        DB::transaction(function () use ($validated) {
            $validated['user_id'] = Auth::id();
            $absentParticipants = $validated['absent_participants'] ?? [];
            unset($validated['absent_participants']);

            $attendance = TalentAttendance::create($validated);

            // Create absent participants records
            foreach ($absentParticipants as $participant) {
                if (!empty($participant['participant_name']) && !empty($participant['participant_number'])) {
                    TalentAbsentParticipant::create([
                        'attendance_id' => $attendance->id,
                        'participant_name' => $participant['participant_name'],
                        'participant_number' => $participant['participant_number'],
                    ]);
                }
            }
        });

        return redirect()->route('talent-attendance.index')
            ->with('success', 'Attendance record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TalentAttendance $talentAttendance): View
    {
        $this->authorize('view', $talentAttendance);
        $talentAttendance->load('absentParticipants');
        $attendance = $talentAttendance;
        return view('talent-attendance.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TalentAttendance $talentAttendance): View
    {
        $this->authorize('update', $talentAttendance);
        $talentAttendance->load('absentParticipants');
        return view('talent-attendance.edit', compact('talentAttendance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TalentAttendance $talentAttendance): RedirectResponse
    {
        $this->authorize('update', $talentAttendance);

        $validated = $request->validate([
            'date' => 'required|date',
            'instructor_name' => 'required|string|max:255',
            'talent_taught' => 'required|string|max:255',
            'attendance_count' => 'required|integer|min:0',
            'instructor_comments' => 'nullable|string',
            'supervisor_comments' => 'nullable|string',
            'lesson_topic' => 'required|string|max:255',
            'absent_participants' => 'nullable|array',
            'absent_participants.*.participant_name' => 'required_with:absent_participants|string|max:255',
            'absent_participants.*.participant_number' => 'required_with:absent_participants|string|max:255',
        ]);

        DB::transaction(function () use ($validated, $talentAttendance) {
            $absentParticipants = $validated['absent_participants'] ?? [];
            unset($validated['absent_participants']);

            $talentAttendance->update($validated);

            // Delete existing absent participants and create new ones
            $talentAttendance->absentParticipants()->delete();
            
            foreach ($absentParticipants as $participant) {
                if (!empty($participant['participant_name']) && !empty($participant['participant_number'])) {
                    TalentAbsentParticipant::create([
                        'attendance_id' => $talentAttendance->id,
                        'participant_name' => $participant['participant_name'],
                        'participant_number' => $participant['participant_number'],
                    ]);
                }
            }
        });

        return redirect()->route('talent-attendance.index')
            ->with('success', 'Attendance record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TalentAttendance $talentAttendance): RedirectResponse
    {
        $this->authorize('delete', $talentAttendance);
        
        $talentAttendance->delete();

        return redirect()->route('talent-attendance.index')
            ->with('success', 'Attendance record deleted successfully.');
    }
}
