<?php

namespace App\Http\Controllers;

use App\Models\CurriculumAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurriculumAttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $curriculumAttendances = CurriculumAttendance::with(['user', 'participants'])
                ->latest()
                ->paginate(15);
        } else {
            $curriculumAttendances = CurriculumAttendance::with(['user', 'participants'])
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(15);
        }

        return view('curriculum-attendance.index', compact('curriculumAttendances'));
    }

    public function create()
    {
        return view('curriculum-attendance.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tarehe' => 'required|date',
            'jina_la_mwalimu' => 'required|string|max:255',
            'somo' => 'required|string|max:255',
            'mada' => 'required|string',
            'maoni_ya_mwalimu' => 'nullable|string',
            'maoni_ya_msimamizi' => 'nullable|string',
            'participants' => 'nullable|array',
            'participants.*.participant_name' => 'nullable|string|max:255',
            'participants.*.participant_number' => 'nullable|string|max:50',
            'participants.*.status' => 'nullable|in:present,absent',
        ]);

        $participants = collect($request->input('participants', []))
            ->filter(fn ($participant) => !empty(trim($participant['participant_name'] ?? '')))
            ->values();

        $attendanceData = collect($validated)->except('participants')->toArray();
        $attendanceData['wahudhuria'] = $participants->count();
        $attendanceData['user_id'] = Auth::id();

        $attendance = CurriculumAttendance::create($attendanceData);

        foreach ($participants as $participant) {
            $attendance->participants()->create([
                'participant_name' => trim($participant['participant_name']),
                'participant_number' => !empty(trim($participant['participant_number'] ?? ''))
                    ? trim($participant['participant_number'])
                    : null,
                'status' => $participant['status'] ?? 'present',
                'user_id' => Auth::id(),
            ]);
        }

        return redirect()->route('curriculum-attendance.index')
            ->with('success', 'Curriculum attendance created successfully.');
    }

    public function show(CurriculumAttendance $curriculumAttendance)
    {
        $this->authorizeUser($curriculumAttendance);

        $curriculumAttendance->load(['user', 'participants']);

        return view('curriculum-attendance.show', compact('curriculumAttendance'));
    }

    public function edit(CurriculumAttendance $curriculumAttendance)
    {
        $this->authorizeUser($curriculumAttendance);

        $curriculumAttendance->load('participants');

        return view('curriculum-attendance.edit', compact('curriculumAttendance'));
    }

    public function update(Request $request, CurriculumAttendance $curriculumAttendance)
    {
        $this->authorizeUser($curriculumAttendance);

        $validated = $request->validate([
            'tarehe' => 'required|date',
            'jina_la_mwalimu' => 'required|string|max:255',
            'somo' => 'required|string|max:255',
            'mada' => 'required|string',
            'maoni_ya_mwalimu' => 'nullable|string',
            'maoni_ya_msimamizi' => 'nullable|string',
            'participants' => 'nullable|array',
            'participants.*.participant_name' => 'nullable|string|max:255',
            'participants.*.participant_number' => 'nullable|string|max:50',
            'participants.*.status' => 'nullable|in:present,absent',
        ]);

        $participants = collect($request->input('participants', []))
            ->filter(fn ($participant) => !empty(trim($participant['participant_name'] ?? '')))
            ->values();

        $attendanceData = collect($validated)->except('participants')->toArray();
        $attendanceData['wahudhuria'] = $participants->count();

        $curriculumAttendance->update($attendanceData);
        $curriculumAttendance->participants()->delete();

        foreach ($participants as $participant) {
            $curriculumAttendance->participants()->create([
                'participant_name' => trim($participant['participant_name']),
                'participant_number' => !empty(trim($participant['participant_number'] ?? ''))
                    ? trim($participant['participant_number'])
                    : null,
                'status' => $participant['status'] ?? 'present',
                'user_id' => Auth::id(),
            ]);
        }

        return redirect()->route('curriculum-attendance.show', $curriculumAttendance->id)
            ->with('success', 'Curriculum attendance updated successfully.');
    }

    public function destroy(CurriculumAttendance $curriculumAttendance)
    {
        $this->authorizeUser($curriculumAttendance);

        $curriculumAttendance->participants()->delete();
        $curriculumAttendance->delete();

        return redirect()->route('curriculum-attendance.index')
            ->with('success', 'Curriculum attendance deleted successfully.');
    }

    protected function authorizeUser(CurriculumAttendance $curriculumAttendance): void
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && (int) $curriculumAttendance->user_id !== (int) $user->id) {
            abort(403, 'Huruhusiwi kuona taarifa za mtumiaji mwingine.');
        }
    }
}