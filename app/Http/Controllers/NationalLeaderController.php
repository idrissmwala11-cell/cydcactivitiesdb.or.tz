<?php

namespace App\Http\Controllers;

use App\Models\NationalLeader;
use App\Models\NationalLeaderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NationalLeaderController extends Controller
{
    protected function authorizeLeaderAccess(NationalLeader $nationalLeader): void
    {
        $this->authorizeCenterRecord($nationalLeader);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nationalLeaders = $this->scopeRecordsVisibleToUser(NationalLeader::with(['user', 'nationalLeaderDetails']), Auth::user())
            ->latest()
            ->paginate(10);
            
        return view('national-leadership.index', compact('nationalLeaders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('national-leadership.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'center' => 'required|string|max:255',
            'term_end' => 'required|date',
            'challenges' => 'nullable|string',
            'comments' => 'nullable|string',
            'leaders' => 'required|array|min:1',
            'leaders.*.leader_name' => 'required|string|max:255',
            'leaders.*.participant_number' => 'required|string|max:255',
            'leaders.*.position' => 'required|string|max:255',
            'leaders.*.gender' => 'required|in:male,female'
        ]);

        // Create the main NationalLeader record
        $nationalLeader = NationalLeader::create([
            'center' => $request->center,
            'term_end' => $request->term_end,
            'challenges' => $request->challenges,
            'comments' => $request->comments,
            'user_id' => Auth::id()
        ]);
        
        // Create NationalLeaderDetail records for each leader
        foreach ($request->leaders as $leader) {
            NationalLeaderDetail::create([
                'leader_id' => $nationalLeader->id,
                'leader_name' => $leader['leader_name'],
                'participant_number' => $leader['participant_number'],
                'position' => $leader['position'],
                'gender' => $leader['gender']
            ]);
        }

        return redirect()->route('national-leadership.index')
            ->with('success', 'National leadership information saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(NationalLeader $nationalLeadership)
    {
        $this->authorizeLeaderAccess($nationalLeadership);
        $nationalLeadership->load(['user', 'nationalLeaderDetails']);
        return view('national-leadership.show', compact('nationalLeadership'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NationalLeader $nationalLeadership)
    {
        $this->authorizeLeaderAccess($nationalLeadership);
        $nationalLeadership->load('nationalLeaderDetails');
        return view('national-leadership.edit', compact('nationalLeadership'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NationalLeader $nationalLeadership)
    {
        $this->authorizeLeaderAccess($nationalLeadership);
        
        $validated = $request->validate([
            'center' => 'required|string|max:255',
            'term_end' => 'required|date',
            'challenges' => 'nullable|string',
            'comments' => 'nullable|string',
            'leaders' => 'required|array|min:1',
            'leaders.*.leader_name' => 'required|string|max:255',
            'leaders.*.participant_number' => 'required|string|max:255',
            'leaders.*.position' => 'required|string|max:255',
            'leaders.*.gender' => 'required|in:male,female'
        ]);

        // Update the national leader record
        $nationalLeadership->update([
            'center' => $validated['center'],
            'term_end' => $validated['term_end'],
            'challenges' => $validated['challenges'],
            'comments' => $validated['comments']
        ]);
        
        // Delete existing leader details and create new ones
        $nationalLeadership->nationalLeaderDetails()->delete();
        
        foreach ($validated['leaders'] as $leader) {
            $nationalLeadership->nationalLeaderDetails()->create([
                'leader_name' => $leader['leader_name'],
                'participant_number' => $leader['participant_number'],
                'position' => $leader['position'],
                'gender' => $leader['gender']
            ]);
        }

        return redirect()->route('national-leadership.index')
            ->with('success', 'National leadership information updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NationalLeader $nationalLeadership)
    {
        $this->authorizeLeaderAccess($nationalLeadership);
        
        $nationalLeadership->delete();

        return redirect()->route('national-leadership.index')
            ->with('success', 'National leadership information deleted successfully!');
    }
}
