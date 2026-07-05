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

    public function index(): View
    {
        $user = Auth::user();

        $attendances = $this->scopeRecordsVisibleToUser(SkillsAttendance::with(['user', 'absentParticipants']), $user)
            ->latest('date')
            ->paginate(15);

        return view('skills-attendance.index', compact('attendances'));
    }

    public function create(): View
    {
        return view('skills-attendance.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'teacher_name' => 'required|string|max:255',
            'lesson_topic' => 'required|string|max:255',
            'present_count' => 'nullable|integer|min:0',
            'teacher_comments' => 'nullable|string',
            'supervisor_comments' => 'nullable|string',
            'lesson_topic_details' => 'nullable|string',
            'participants' => 'nullable|array',
            'participants.*.participant_name' => 'nullable|string|max:255',
            'participants.*.participant_number' => 'nullable|string|max:255',
            'participants.*.status' => 'nullable|in:present,absent',
            'absent_participants' => 'nullable|array',
            'absent_participants.*.participant_name' => 'nullable|string|max:255',
            'absent_participants.*.participant_number' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $participants = $this->participantsFromRequest($request);
            $attendanceData = collect($validated)->except(['participants', 'absent_participants'])->toArray();
            $attendanceData['user_id'] = Auth::id();
            $attendanceData['present_count'] = $participants->where('status', 'present')->count();

            $attendance = SkillsAttendance::create($attendanceData);

            foreach ($participants as $participant) {
                AbsentParticipant::create([
                    'attendance_id' => $attendance->id,
                    'participant_name' => trim($participant['participant_name']),
                    'participant_number' => !empty(trim($participant['participant_number'] ?? ''))
                        ? trim($participant['participant_number'])
                        : null,
                    'status' => $participant['status'] ?? 'absent',
                    'attendance_type' => 'skills',
                    'user_id' => Auth::id(),
                ]);
            }
        });

        return redirect()->route('skills-attendance.index')
            ->with('success', 'Skills attendance record created successfully.');
    }

    public function show(SkillsAttendance $skillsAttendance): View
    {
        $this->authorizeUser($skillsAttendance);

        $skillsAttendance->load(['user', 'absentParticipants']);

        return view('skills-attendance.show', compact('skillsAttendance'));
    }

    public function edit(SkillsAttendance $skillsAttendance): View
    {
        $this->authorizeUser($skillsAttendance);

        $skillsAttendance->load('absentParticipants');

        return view('skills-attendance.edit', compact('skillsAttendance'));
    }

    public function update(Request $request, SkillsAttendance $skillsAttendance): RedirectResponse
    {
        $this->authorizeUser($skillsAttendance);

        $validated = $request->validate([
            'date' => 'required|date',
            'teacher_name' => 'required|string|max:255',
            'lesson_topic' => 'required|string|max:255',
            'present_count' => 'nullable|integer|min:0',
            'teacher_comments' => 'nullable|string',
            'supervisor_comments' => 'nullable|string',
            'lesson_topic_details' => 'nullable|string',
            'participants' => 'nullable|array',
            'participants.*.participant_name' => 'nullable|string|max:255',
            'participants.*.participant_number' => 'nullable|string|max:255',
            'participants.*.status' => 'nullable|in:present,absent',
            'absent_participants' => 'nullable|array',
            'absent_participants.*.participant_name' => 'nullable|string|max:255',
            'absent_participants.*.participant_number' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validated, $request, $skillsAttendance) {
            $participants = $this->participantsFromRequest($request);
            $attendanceData = collect($validated)->except(['participants', 'absent_participants'])->toArray();
            $attendanceData['present_count'] = $participants->where('status', 'present')->count();

            $skillsAttendance->update($attendanceData);

            $skillsAttendance->absentParticipants()->delete();

            foreach ($participants as $participant) {
                AbsentParticipant::create([
                    'attendance_id' => $skillsAttendance->id,
                    'participant_name' => trim($participant['participant_name']),
                    'participant_number' => !empty(trim($participant['participant_number'] ?? ''))
                        ? trim($participant['participant_number'])
                        : null,
                    'status' => $participant['status'] ?? 'absent',
                    'attendance_type' => 'skills',
                    'user_id' => Auth::id(),
                ]);
            }
        });

        return redirect()->route('skills-attendance.show', $skillsAttendance->id)
            ->with('success', 'Skills attendance record updated successfully.');
    }

    public function destroy(SkillsAttendance $skillsAttendance): RedirectResponse
    {
        $this->authorizeUser($skillsAttendance);

        $skillsAttendance->delete();

        return redirect()->route('skills-attendance.index')
            ->with('success', 'Skills attendance record deleted successfully.');
    }

    protected function authorizeUser(SkillsAttendance $skillsAttendance): void
    {
        $this->authorizeCenterRecord($skillsAttendance, 'Huruhusiwi kuona taarifa za center nyingine.');
    }

    private function participantsFromRequest(Request $request)
    {
        $participants = $request->input('participants');

        if ($participants === null) {
            $participants = collect($request->input('absent_participants', []))
                ->map(function ($participant) {
                    $participant['status'] = 'absent';

                    return $participant;
                })
                ->all();
        }

        return collect($participants)
            ->filter(function ($participant) {
                return !empty(trim($participant['participant_name'] ?? ''));
            })
            ->map(function ($participant) {
                $participant['status'] = ($participant['status'] ?? 'present') === 'absent'
                    ? 'absent'
                    : 'present';

                return $participant;
            })
            ->values();
    }
}
