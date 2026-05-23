<?php

namespace App\Http\Controllers;

use App\Models\MasomoYaMtaala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasomoYaMtaalaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $masomoYaMtaala = MasomoYaMtaala::with('user')->paginate(15);
        return view('masomo-ya-mtaala.index', compact('masomoYaMtaala'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('masomo-ya-mtaala.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'participant_name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'instructor_name' => 'required|string|max:255',
            'lesson_topic' => 'required|string|max:255',
            'lesson_date' => 'required|date',
            'attendance_status' => 'required|string|max:255',
            'performance_rating' => 'required|integer|min:1|max:10',
            'instructor_comments' => 'nullable|string',
            'supervisor_comments' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        
        MasomoYaMtaala::create($validated);
        
        return redirect()->route('submissions.masomo-ya-mtaala')
            ->with('success', 'Masomo ya mtaala record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasomoYaMtaala $masomoYaMtaala)
    {
        return view('masomo-ya-mtaala.show', compact('masomoYaMtaala'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasomoYaMtaala $masomoYaMtaala)
    {
        return view('masomo-ya-mtaala.edit', compact('masomoYaMtaala'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasomoYaMtaala $masomoYaMtaala)
    {
        $validated = $request->validate([
            'participant_name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'instructor_name' => 'required|string|max:255',
            'lesson_topic' => 'required|string|max:255',
            'lesson_date' => 'required|date',
            'attendance_status' => 'required|string|max:255',
            'performance_rating' => 'required|integer|min:1|max:10',
            'instructor_comments' => 'nullable|string',
            'supervisor_comments' => 'nullable|string',
        ]);
        
        $masomoYaMtaala->update($validated);
        
        return redirect()->route('submissions.masomo-ya-mtaala')
            ->with('success', 'Masomo ya mtaala record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasomoYaMtaala $masomoYaMtaala)
    {
        $masomoYaMtaala->delete();
        
        return redirect()->route('submissions.masomo-ya-mtaala')
            ->with('success', 'Masomo ya mtaala record deleted successfully.');
    }
}
