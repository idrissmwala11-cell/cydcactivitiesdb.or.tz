<?php

namespace App\Http\Controllers;

use App\Models\LocalSponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocalSponsorshipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        $localSponsorships = LocalSponsorship::with('user')
            ->when($user->role !== 'admin', fn ($query) => $query->where('user_id', $user->id))
            ->latest()
            ->paginate(15);

        return view('local-sponsorship.index', compact('localSponsorships'));
    }

    public function create()
    {
        return view('local-sponsorship.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);
        $validated['user_id'] = Auth::id();

        LocalSponsorship::create($validated);

        return redirect()
            ->route('local-sponsorship.index')
            ->with('success', 'Local sponsorship record saved successfully.');
    }

    public function show(LocalSponsorship $localSponsorship)
    {
        $this->authorizeUser($localSponsorship);
        $localSponsorship->load('user');

        return view('local-sponsorship.show', compact('localSponsorship'));
    }

    public function edit(LocalSponsorship $localSponsorship)
    {
        $this->authorizeUser($localSponsorship);

        return view('local-sponsorship.edit', compact('localSponsorship'));
    }

    public function update(Request $request, LocalSponsorship $localSponsorship)
    {
        $this->authorizeUser($localSponsorship);

        $validated = $this->validateData($request);
        $localSponsorship->update($validated);

        return redirect()
            ->route('local-sponsorship.show', $localSponsorship)
            ->with('success', 'Local sponsorship record updated successfully.');
    }

    public function destroy(LocalSponsorship $localSponsorship)
    {
        $this->authorizeUser($localSponsorship);
        $localSponsorship->delete();

        return redirect()
            ->route('local-sponsorship.index')
            ->with('success', 'Local sponsorship record deleted successfully.');
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'child_name' => ['required', 'string', 'max:255'],
            'child_age' => ['required', 'integer', 'min:0', 'max:30'],
            'child_location' => ['required', 'string', 'max:255'],
            'sponsor_type' => ['required', 'string', 'in:Church,Group,Individual'],
            'sponsor_name' => ['required', 'string', 'max:255'],
            'local_number' => ['required', 'string', 'max:255'],
        ]);
    }

    protected function authorizeUser(LocalSponsorship $localSponsorship): void
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && (int) $localSponsorship->user_id !== (int) $user->id) {
            abort(403, 'You are not allowed to access another user record.');
        }
    }
}
