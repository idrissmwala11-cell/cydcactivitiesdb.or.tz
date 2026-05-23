<?php

namespace App\Http\Controllers;

use App\Models\MasomoYaFani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasomoYaFaniController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $faniRecords = MasomoYaFani::with('user')
                ->latest('date')
                ->paginate(15);
        } else {
            $faniRecords = MasomoYaFani::with('user')
                ->where('user_id', $user->id)
                ->latest('date')
                ->paginate(15);
        }

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
            'status' => 'required|in:draft,submitted',
        ]);

        $validated['user_id'] = Auth::id();

        MasomoYaFani::create($validated);

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
            'status' => 'required|in:draft,submitted,approved,rejected',
        ]);

        $masomoYaFani->update($validated);

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
        $user = Auth::user();

        if ($user->role !== 'admin' && $masomoYaFani->user_id != $user->id) {
            abort(403);
        }
    }
}