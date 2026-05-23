<?php

namespace App\Http\Controllers;

use App\Models\MasomoYaFani;
use Illuminate\Http\Request;

class MasomoYaFaniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faniRecords = MasomoYaFani::with('user')->orderByDesc('created_at')->paginate(15);
        return view('masomo-ya-fani.index', compact('faniRecords'));
    }

    /**
     * Display the specified resource.
     */
    public function show(MasomoYaFani $masomoYaFani)
    {
        $masomoYaFani->load('user');
        return view('masomo-ya-fani.show', compact('masomoYaFani'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasomoYaFani $masomoYaFani)
    {
        return view('masomo-ya-fani.edit', compact('masomoYaFani'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasomoYaFani $masomoYaFani)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'teacher' => 'required|string|max:255',
            'fani_type' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'student_preferences' => 'nullable|string',
            'student_feedback' => 'nullable|string',
            'teacher_feedback' => 'nullable|string',
            'status' => 'required|in:draft,submitted',
        ]);

        $masomoYaFani->update($validated);

        return redirect()->route('admin.masomo-ya-fani.index')
            ->with('success', 'Masomo ya Fani record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasomoYaFani $masomoYaFani)
    {
        $masomoYaFani->delete();

        return redirect()->route('admin.masomo-ya-fani.index')
            ->with('success', 'Masomo ya Fani record deleted successfully.');
    }
}