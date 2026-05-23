<?php

namespace App\Http\Controllers;

use App\Models\GroupMember;
use App\Models\SavingGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = GroupMember::with(['savingGroup', 'user']);
        
        // Filter by group
        if ($request->filled('group_id')) {
            $query->where('group_id', $request->group_id);
        }
        
        // Filter by center ID
        if ($request->filled('center_id')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('center_id', $request->center_id);
            });
        }
        
        // Filter by cluster
        if ($request->filled('cluster_name')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('cluster_name', $request->cluster_name);
            });
        }
        
        $groupMembers = $query->paginate(15);
        
        // Get all saving groups for filter dropdown
        $savingGroups = SavingGroup::all();
        
        // Get unique center IDs and clusters for filter dropdowns
        $centerIds = User::whereNotNull('center_id')
                        ->distinct()
                        ->pluck('center_id')
                        ->sort();
                        
        $clusters = User::whereNotNull('cluster_name')
                       ->distinct()
                       ->pluck('cluster_name')
                       ->sort();
        
        return view('group-members.index', compact('groupMembers', 'savingGroups', 'centerIds', 'clusters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $savingGroups = SavingGroup::all();
        return view('group-members.create', compact('savingGroups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'group_id' => 'required|exists:saving_groups,id',
            'member_name' => 'required|string|max:255',
            'member_phone' => 'required|string|max:20',
        ]);

        $validated['user_id'] = Auth::id();
        
        GroupMember::create($validated);
        
        return redirect()->route('group-members.index')
            ->with('success', 'Group member created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GroupMember $groupMember)
    {
        $groupMember->load('savingGroup');
        return view('group-members.show', compact('groupMember'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GroupMember $groupMember)
    {
        $savingGroups = SavingGroup::all();
        return view('group-members.edit', compact('groupMember', 'savingGroups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GroupMember $groupMember)
    {
        $validated = $request->validate([
            'group_id' => 'required|exists:saving_groups,id',
            'member_name' => 'required|string|max:255',
            'member_phone' => 'required|string|max:20',
        ]);
        
        $groupMember->update($validated);
        
        return redirect()->route('group-members.index')
            ->with('success', 'Group member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GroupMember $groupMember)
    {
        $groupMember->delete();
        
        return redirect()->route('group-members.index')
            ->with('success', 'Group member deleted successfully.');
    }
}
