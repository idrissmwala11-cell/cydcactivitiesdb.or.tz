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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $curriculumAttendances = CurriculumAttendance::with(['user', 'absentParticipants'])->paginate(15);
        return view('curriculum-attendance.index', compact('curriculumAttendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('curriculum-attendance.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tarehe' => 'required|date',
            'jina_la_mwalimu' => 'required|string|max:255',
            'somo' => 'required|string|max:255',
            'wahudhuria' => 'required|integer|min:0',
            'mada' => 'required|string',
            'maoni_ya_mwalimu' => 'nullable|string',
            'maoni_ya_msimamizi' => 'nullable|string',
            'absent_participants' => 'nullable|array',
            'absent_participants.*.name' => 'required|string|max:255',
            'absent_participants.*.reason' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();
        
        // Create the curriculum attendance record
        $curriculumAttendance = CurriculumAttendance::create([
            'user_id' => $validated['user_id'],
            'tarehe' => $validated['tarehe'],
            'jina_la_mwalimu' => $validated['jina_la_mwalimu'],
            'somo' => $validated['somo'],
            'wahudhuria' => $validated['wahudhuria'],
            'mada' => $validated['mada'],
            'maoni_ya_mwalimu' => $validated['maoni_ya_mwalimu'] ?? null,
            'maoni_ya_msimamizi' => $validated['maoni_ya_msimamizi'] ?? null,
        ]);
        
        // Handle absent participants if provided
        if (isset($validated['absent_participants'])) {
            foreach ($validated['absent_participants'] as $participant) {
                $curriculumAttendance->absentParticipants()->create([
                    'name' => $participant['name'],
                    'reason' => $participant['reason'] ?? null,
                ]);
            }
        }
        
        return redirect()->route('curriculum-attendance.create')
            ->with('success', 'Curriculum attendance created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CurriculumAttendance $curriculumAttendance)
    {
        $curriculumAttendance->load('absentParticipants');
        return view('curriculum-attendance.show', compact('curriculumAttendance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CurriculumAttendance $curriculumAttendance)
    {
        return view('curriculum-attendance.edit', compact('curriculumAttendance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CurriculumAttendance $curriculumAttendance)
    {
        $validated = $request->validate([
            'tarehe' => 'required|date',
            'jina_la_mwalimu' => 'required|string|max:255',
            'somo' => 'required|string|max:255',
            'wahudhuria' => 'required|integer|min:0',
            'mada' => 'required|string',
            'maoni_ya_mwalimu' => 'nullable|string',
            'maoni_ya_msimamizi' => 'nullable|string',
            'absent_participants' => 'nullable|array',
            'absent_participants.*.name' => 'required|string|max:255',
            'absent_participants.*.reason' => 'nullable|string|max:255',
        ]);
        
        // Update the curriculum attendance record
        $curriculumAttendance->update([
            'tarehe' => $validated['tarehe'],
            'jina_la_mwalimu' => $validated['jina_la_mwalimu'],
            'somo' => $validated['somo'],
            'wahudhuria' => $validated['wahudhuria'],
            'mada' => $validated['mada'],
            'maoni_ya_mwalimu' => $validated['maoni_ya_mwalimu'] ?? null,
            'maoni_ya_msimamizi' => $validated['maoni_ya_msimamizi'] ?? null,
        ]);
        
        // Update absent participants
        $curriculumAttendance->absentParticipants()->delete(); // Remove existing
        if (isset($validated['absent_participants'])) {
            foreach ($validated['absent_participants'] as $participant) {
                $curriculumAttendance->absentParticipants()->create([
                    'name' => $participant['name'],
                    'reason' => $participant['reason'] ?? null,
                ]);
            }
        }
        
        return redirect()->route('curriculum-attendance.index')
            ->with('success', 'Curriculum attendance updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CurriculumAttendance $curriculumAttendance)
    {
        $curriculumAttendance->delete();
        
        return redirect()->route('curriculum-attendance.index')
            ->with('success', 'Curriculum attendance deleted successfully.');
    }
}
