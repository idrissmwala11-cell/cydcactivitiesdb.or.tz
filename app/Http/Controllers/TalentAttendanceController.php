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

    public function index(): View
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $attendances = TalentAttendance::with(['user', 'absentParticipants'])
                ->latest('date')
                ->paginate(10);
        } else {
            $attendances = TalentAttendance::with(['user', 'absentParticipants'])
                ->where('user_id', $user->id)
                ->latest('date')
                ->paginate(10);
        }

        return view('talent-attendance.index', compact('attendances'));
    }

    public function create(): View
    {
        return view('talent-attendance.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'instructor_name' => 'required|string|max:255',
            'talent_taught' => 'required|string|max:255',
            'lesson_topic' => 'required|string|max:255',
            'instructor_comments' => 'nullable|string',
            'supervisor_comments' => 'nullable|string',

            'participants' => 'nullable|array',
            'participants.*.participant_name' => 'nullable|string|max:255',
            'participants.*.participant_number' => 'nullable|string|max:255',
            'participants.*.status' => 'nullable|in:present,absent',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $participants = collect($request->input('participants', []))
                ->filter(function ($participant) {
                    return !empty(trim($participant['participant_name'] ?? ''));
                })
                ->values();

            $attendance = TalentAttendance::create([
                'date' => $validated['date'],
                'instructor_name' => $validated['instructor_name'],
                'talent_taught' => $validated['talent_taught'],
                'lesson_topic' => $validated['lesson_topic'],
                'attendance_count' => $participants->count(),
                'instructor_comments' => $validated['instructor_comments'] ?? null,
                'supervisor_comments' => $validated['supervisor_comments'] ?? null,
                'user_id' => Auth::id(),
            ]);

            foreach ($participants as $participant) {
                TalentAbsentParticipant::create([
                    'attendance_id' => $attendance->id,
                    'participant_name' => trim($participant['participant_name']),
                    'participant_number' => !empty(trim($participant['participant_number'] ?? ''))
                        ? trim($participant['participant_number'])
                        : null,
                    'status' => $participant['status'] ?? 'present',
                    'user_id' => Auth::id(),
                ]);
            }
        });

        return redirect()->route('talent-attendance.index')
            ->with('success', 'Attendance record created successfully.');
    }

    public function show(TalentAttendance $talentAttendance): View
    {
        $this->authorizeUser($talentAttendance);

        $talentAttendance->load(['user', 'absentParticipants']);

        $attendance = $talentAttendance;

        return view('talent-attendance.show', compact('attendance'));
    }

    public function edit(TalentAttendance $talentAttendance): View
    {
        $this->authorizeUser($talentAttendance);

        $talentAttendance->load('absentParticipants');

        $attendance = $talentAttendance;

        return view('talent-attendance.edit', compact('attendance'));
    }

    public function update(Request $request, TalentAttendance $talentAttendance): RedirectResponse
    {
        $this->authorizeUser($talentAttendance);

        $validated = $request->validate([
            'date' => 'required|date',
            'instructor_name' => 'required|string|max:255',
            'talent_taught' => 'required|string|max:255',
            'lesson_topic' => 'required|string|max:255',
            'instructor_comments' => 'nullable|string',
            'supervisor_comments' => 'nullable|string',

            'participants' => 'nullable|array',
            'participants.*.participant_name' => 'nullable|string|max:255',
            'participants.*.participant_number' => 'nullable|string|max:255',
            'participants.*.status' => 'nullable|in:present,absent',
        ]);

        DB::transaction(function () use ($validated, $request, $talentAttendance) {
            $participants = collect($request->input('participants', []))
                ->filter(function ($participant) {
                    return !empty(trim($participant['participant_name'] ?? ''));
                })
                ->values();

            $talentAttendance->update([
                'date' => $validated['date'],
                'instructor_name' => $validated['instructor_name'],
                'talent_taught' => $validated['talent_taught'],
                'lesson_topic' => $validated['lesson_topic'],
                'attendance_count' => $participants->count(),
                'instructor_comments' => $validated['instructor_comments'] ?? null,
                'supervisor_comments' => $validated['supervisor_comments'] ?? null,
            ]);

            $talentAttendance->absentParticipants()->delete();

            foreach ($participants as $participant) {
                TalentAbsentParticipant::create([
                    'attendance_id' => $talentAttendance->id,
                    'participant_name' => trim($participant['participant_name']),
                    'participant_number' => !empty(trim($participant['participant_number'] ?? ''))
                        ? trim($participant['participant_number'])
                        : null,
                    'status' => $participant['status'] ?? 'present',
                    'user_id' => Auth::id(),
                ]);
            }
        });

        return redirect()->route('talent-attendance.show', $talentAttendance->id)
            ->with('success', 'Attendance record updated successfully.');
    }

    public function destroy(TalentAttendance $talentAttendance): RedirectResponse
    {
        $this->authorizeUser($talentAttendance);

        $talentAttendance->absentParticipants()->delete();
        $talentAttendance->delete();

        return redirect()->route('talent-attendance.index')
            ->with('success', 'Attendance record deleted successfully.');
    }

    protected function authorizeUser(TalentAttendance $talentAttendance): void
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && (int) $talentAttendance->user_id !== (int) $user->id) {
            abort(403, 'This action is unauthorized.');
        }
    }
}