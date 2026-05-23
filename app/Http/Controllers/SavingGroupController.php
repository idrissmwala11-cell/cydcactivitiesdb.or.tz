<?php

namespace App\Http\Controllers;

use App\Models\SavingGroup;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavingGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $savingGroups = SavingGroup::with(['user', 'groupMembers'])
            ->when($user->role !== 'admin', fn ($query) => $query->where('user_id', $user->id))
            ->latest()
            ->paginate(15);

        return view('saving-groups.index', compact('savingGroups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('saving-groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
            'member_count' => 'required|integer|min:1',
            'group_mentor' => 'required|string|max:255',
            'registration_status' => 'required|string|max:255',
            'savings_level' => 'required|string|max:255',
            'bank_account' => 'required|string|max:255',
            'group_progress' => 'nullable|string',
            'members' => 'nullable|array',
            'members.*.name' => 'nullable|string|max:255',
            'members.*.phone' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();

        $members = collect($validated['members'] ?? [])
            ->filter(fn ($member) => filled($member['name'] ?? null) || filled($member['phone'] ?? null))
            ->values()
            ->all();

        unset($validated['members']);

        $savingGroup = SavingGroup::create($validated);
        $this->syncMembers($savingGroup, $members);
        
        return redirect()->route('saving-groups.index')
            ->with('success', 'Saving group created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SavingGroup $savingGroup)
    {
        $this->authorizeSavingGroup($savingGroup);
        $savingGroup->load(['groupMembers', 'user']);

        return view('saving-groups.show', compact('savingGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SavingGroup $savingGroup)
    {
        $this->authorizeSavingGroup($savingGroup);

        return view('saving-groups.edit', compact('savingGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SavingGroup $savingGroup)
    {
        $this->authorizeSavingGroup($savingGroup);

        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
            'member_count' => 'required|integer|min:1',
            'group_mentor' => 'required|string|max:255',
            'registration_status' => 'required|string|max:255',
            'savings_level' => 'required|string|max:255',
            'bank_account' => 'required|string|max:255',
            'group_progress' => 'nullable|string',
            'members' => 'nullable|array',
            'members.*.name' => 'nullable|string|max:255',
            'members.*.phone' => 'nullable|string|max:255',
        ]);

        $members = collect($validated['members'] ?? [])
            ->filter(fn ($member) => filled($member['name'] ?? null) || filled($member['phone'] ?? null))
            ->values()
            ->all();

        unset($validated['members']);

        $savingGroup->update($validated);
        $this->syncMembers($savingGroup, $members);
        
        return redirect()->route('saving-groups.index')
            ->with('success', 'Saving group updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SavingGroup $savingGroup)
    {
        $this->authorizeSavingGroup($savingGroup);

        $savingGroup->delete();
        
        return redirect()->route('saving-groups.index')
            ->with('success', 'Saving group deleted successfully.');
    }

    private function authorizeSavingGroup(SavingGroup $savingGroup): void
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && (int) $savingGroup->user_id !== (int) $user->id) {
            abort(403, 'You are not allowed to access another user record.');
        }
    }

    private function syncMembers(SavingGroup $savingGroup, array $members): void
    {
        $savingGroup->groupMembers()->delete();

        foreach ($members as $member) {
            GroupMember::create([
                'group_id' => $savingGroup->id,
                'member_name' => $member['name'] ?? '',
                'member_phone' => $member['phone'] ?? null,
                'user_id' => Auth::id(),
            ]);
        }
    }
}
