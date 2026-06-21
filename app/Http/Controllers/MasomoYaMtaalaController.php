<?php

namespace App\Http\Controllers;

use App\Models\MasomoYaMtaala;
use App\Support\ProgramDayAttendance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MasomoYaMtaalaController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $masomoYaMtaala = $this->scopeRecordsVisibleToUser(MasomoYaMtaala::with('user'), $user)
            ->latest('date')
            ->paginate(10);

        return view('masomo-ya-mtaala.index', compact('masomoYaMtaala'));
    }

    public function create(): View
    {
        $existingSubmission = MasomoYaMtaala::where('user_id', Auth::id())
            ->where('status', 'draft')
            ->latest('id')
            ->first();

        return view('masomo-ya-mtaala.create', compact('existingSubmission'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'jina_la_mwalimu' => 'required|string|max:255',
            'somo_analofundisha' => 'required|string|max:255',
            'category' => 'required|in:kiroho,kimwili,kiakili,kijamii',
            'darasa_la_mjaka_mingapi' => 'nullable|string|max:255',
            'mada_aliyo_fundisha' => 'nullable|string',
            'maoni_ya_mwanafunzi' => 'nullable|string',
            'maoni_ya_mwalimu' => 'nullable|string',
            'participant_roster_text' => 'nullable|string',
            'attendance_marker' => 'nullable|string',
            'present_participant_numbers' => 'nullable|array',
            'present_participant_numbers.*' => 'nullable|string',
            'action' => 'required|in:draft,submit',
        ]);

        $attendance = ProgramDayAttendance::fromRequest($request, Auth::id());

        $data = [
            'user_id' => Auth::id(),
            'date' => $validated['date'],
            'teacher' => $validated['jina_la_mwalimu'],
            'subject_type' => $validated['somo_analofundisha'],
            'age_group' => $validated['darasa_la_mjaka_mingapi'] ?? null,
            'topic' => $validated['mada_aliyo_fundisha'] ?? null,
            'category' => $validated['category'],
            'student_feedback' => $validated['maoni_ya_mwanafunzi'] ?? null,
            'teacher_feedback' => $validated['maoni_ya_mwalimu'] ?? null,
            'status' => $validated['action'] === 'submit' ? 'submitted' : 'draft',
        ] + $attendance;

        MasomoYaMtaala::create($data);

        return redirect()
            ->route('submissions.masomo-ya-mtaala.index')
            ->with('success', 'Curriculum Studies record saved successfully.');
    }

    public function show(MasomoYaMtaala $masomoYaMtaala): View
    {
        $this->authorizeUser($masomoYaMtaala);

        $masomoYaMtaala->load('user');

        return view('masomo-ya-mtaala.show', compact('masomoYaMtaala'));
    }

    public function edit(MasomoYaMtaala $masomoYaMtaala): View
    {
        $this->authorizeUser($masomoYaMtaala);

        $existingSubmission = (object) [
            'date' => $masomoYaMtaala->date,
            'jina_la_mwalimu' => $masomoYaMtaala->teacher,
            'somo_analofundisha' => $masomoYaMtaala->subject_type,
            'darasa_la_mjaka_mingapi' => $masomoYaMtaala->age_group,
            'mada_aliyo_fundisha' => $masomoYaMtaala->topic,
            'maoni_ya_mwanafunzi' => $masomoYaMtaala->student_feedback,
            'maoni_ya_mwalimu' => $masomoYaMtaala->teacher_feedback,
            'present_participants' => $masomoYaMtaala->present_participants,
            'absent_participants' => $masomoYaMtaala->absent_participants,
            'status' => $masomoYaMtaala->status,
        ];

        return view('masomo-ya-mtaala.edit', compact('existingSubmission', 'masomoYaMtaala'));
    }

    public function update(Request $request, MasomoYaMtaala $masomoYaMtaala): RedirectResponse
    {
        $this->authorizeUser($masomoYaMtaala);

        $validated = $request->validate([
            'date' => 'required|date',
            'jina_la_mwalimu' => 'required|string|max:255',
            'somo_analofundisha' => 'required|string|max:255',
            'category' => 'required|in:kiroho,kimwili,kiakili,kijamii',
            'darasa_la_mjaka_mingapi' => 'nullable|string|max:255',
            'mada_aliyo_fundisha' => 'nullable|string',
            'maoni_ya_mwanafunzi' => 'nullable|string',
            'maoni_ya_mwalimu' => 'nullable|string',
            'participant_roster_text' => 'nullable|string',
            'attendance_marker' => 'nullable|string',
            'present_participant_numbers' => 'nullable|array',
            'present_participant_numbers.*' => 'nullable|string',
            'action' => 'required|in:draft,submit',
        ]);

        $attendance = ProgramDayAttendance::fromRequest($request, (int) $masomoYaMtaala->user_id);

        $data = [
            'date' => $validated['date'],
            'teacher' => $validated['jina_la_mwalimu'],
            'subject_type' => $validated['somo_analofundisha'],
            'age_group' => $validated['darasa_la_mjaka_mingapi'] ?? null,
            'topic' => $validated['mada_aliyo_fundisha'] ?? null,
            'category' => $validated['category'],
            'student_feedback' => $validated['maoni_ya_mwanafunzi'] ?? null,
            'teacher_feedback' => $validated['maoni_ya_mwalimu'] ?? null,
            'status' => $validated['action'] === 'submit' ? 'submitted' : 'draft',
        ] + $attendance;

        $masomoYaMtaala->update($data);

        return redirect()
            ->route(
                Auth::user()->role === 'admin'
                    ? 'admin.masomo-ya-mtaala.index'
                    : 'submissions.masomo-ya-mtaala.index'
            )
            ->with('success', 'Curriculum Studies updated successfully.');
    }

    public function destroy(MasomoYaMtaala $masomoYaMtaala): RedirectResponse
    {
        $this->authorizeUser($masomoYaMtaala);

        $masomoYaMtaala->delete();

        return redirect()
            ->route(
                Auth::user()->role === 'admin'
                    ? 'admin.masomo-ya-mtaala.index'
                    : 'submissions.masomo-ya-mtaala.index'
            )
            ->with('success', 'Curriculum Studies deleted successfully.');
    }

    private function authorizeUser(MasomoYaMtaala $masomoYaMtaala): void
    {
        $this->authorizeCenterRecord($masomoYaMtaala);
    }
}
