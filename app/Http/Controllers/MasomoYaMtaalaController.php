<?php

namespace App\Http\Controllers;

use App\Models\MasomoYaMtaala;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MasomoYaMtaalaController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $masomoYaMtaala = MasomoYaMtaala::with('user')
                ->latest('date')
                ->paginate(10);
        } else {
            $masomoYaMtaala = MasomoYaMtaala::with('user')
                ->where('user_id', $user->id)
                ->latest('date')
                ->paginate(10);
        }

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
            'action' => 'required|in:draft,submit',
        ]);

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
        ];

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
            'action' => 'required|in:draft,submit',
        ]);

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
        ];

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
        $user = Auth::user();

        if ($user->role !== 'admin' && $masomoYaMtaala->user_id != $user->id) {
            abort(403);
        }
    }
}
