<?php

namespace App\Http\Controllers;

use App\Models\BaseLeader;
use App\Models\BaseLeaderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseLeaderController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $baseLeaders = BaseLeader::with('user')->paginate(15);
        return view('base-leaders.index', compact('baseLeaders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('base-leaders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'base_name' => 'required|string|max:255',
            'leaders_count' => 'required|integer|min:1',
            'term_end' => 'required|date',
            'additional_notes' => 'nullable|string',
            'leaders' => 'required|array|min:1',
            'leaders.*.leader_name' => 'required|string|max:255',
            'leaders.*.leader_position' => 'required|string|max:255',
            'leaders.*.leader_id' => 'required|string|max:255',
            'leaders.*.leader_number' => 'required|integer|min:1',
        ]);

        $validated['user_id'] = Auth::id();
        
        $baseLeader = BaseLeader::create([
            'base_name' => $validated['base_name'],
            'leaders_count' => $validated['leaders_count'], // Use correct database column name
            'term_end' => $validated['term_end'], // Use correct database column name
            'additional_notes' => $validated['additional_notes'], // Use correct database column name
            'meeting_count' => '0', // Default value
            'user_id' => $validated['user_id']
        ]);
        
        foreach ($validated['leaders'] as $index => $leader) {
            $baseLeader->baseLeaderDetails()->create([
                'leader_name' => $leader['leader_name'],
                'leader_position' => $leader['leader_position'],
                'leader_id' => $leader['leader_id'],
                'leader_number' => $leader['leader_number']
            ]);
        }
        
        return redirect()->route('base-leaders.index')
            ->with('success', 'Base leader created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BaseLeader $baseLeader)
    {
        return view('base-leaders.show', compact('baseLeader'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BaseLeader $baseLeader)
    {
        return view('base-leaders.edit', compact('baseLeader'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BaseLeader $baseLeader)
    {
        $validated = $request->validate([
            'base_name' => 'required|string|max:255',
            'leaders_count' => 'required|integer|min:1',
            'term_end' => 'required|date',
            'additional_notes' => 'nullable|string',
        ]);
        
        $validated['meeting_count'] = $validated['meeting_count'] ?? 0;
        
        $baseLeader->update($validated);
        
        // Update leader details
        if ($request->has('leaders')) {
            $baseLeader->baseLeaderDetails()->delete();
            foreach ($request->leaders as $leaderData) {
                $baseLeader->baseLeaderDetails()->create($leaderData);
            }
        }
        
        return redirect()->route('base-leaders.index')
            ->with('success', 'Base leader updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BaseLeader $baseLeader)
    {
        $baseLeader->delete();
        
        return redirect()->route('base-leaders.index')
            ->with('success', 'Base leader deleted successfully.');
    }
    


}
