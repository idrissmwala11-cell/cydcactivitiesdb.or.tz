<?php

namespace App\Http\Controllers;

use App\Models\SavingGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavingGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $savingGroups = SavingGroup::with(['user', 'groupMembers'])->paginate(15);
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
            'bank_account' => 'nullable|string|max:255',
            'group_progress' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        
        SavingGroup::create($validated);
        
        return redirect()->route('saving-groups.index')
            ->with('success', 'Saving group created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SavingGroup $savingGroup)
    {
        $savingGroup->load('groupMembers');
        return view('saving-groups.show', compact('savingGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SavingGroup $savingGroup)
    {
        return view('saving-groups.edit', compact('savingGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SavingGroup $savingGroup)
    {
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
            'member_count' => 'required|integer|min:1',
            'group_mentor' => 'required|string|max:255',
            'registration_status' => 'required|string|max:255',
            'savings_level' => 'required|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'group_progress' => 'nullable|string',
        ]);
        
        $savingGroup->update($validated);
        
        return redirect()->route('saving-groups.index')
            ->with('success', 'Saving group updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SavingGroup $savingGroup)
    {
        $savingGroup->delete();
        
        return redirect()->route('saving-groups.index')
            ->with('success', 'Saving group deleted successfully.');
    }
}
