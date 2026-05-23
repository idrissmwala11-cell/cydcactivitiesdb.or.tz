<?php

namespace App\Http\Controllers;

use App\Models\OutOfMinistryLeader;
use App\Models\OutOfMinistryLeaderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutOfMinistryLeaderController extends Controller
{
    protected function authorizeLeaderAccess(OutOfMinistryLeader $leader): void
    {
        if (Auth::user()->role !== 'admin' && $leader->user_id !== Auth::id()) {
            abort(403);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $outOfMinistryLeaders = OutOfMinistryLeader::with(['user', 'outOfMinistryLeaderDetails'])
            ->when(Auth::user()->role !== 'admin', function ($query) {
                return $query->where('user_id', Auth::id());
            })
            ->latest()
            ->paginate(10);
            
        return view('out-of-ministry-leadership.index', compact('outOfMinistryLeaders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('out-of-ministry-leadership.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'leaders_count' => 'required|integer|min:1',
            'term_end' => 'required|date',
            'leaders' => 'required|array|min:1',
            'leaders.*.leader_name' => 'required|string|max:255',
            'leaders.*.position' => 'required|string|max:255',
            'leaders.*.gender' => 'required|in:male,female',
        ]);

        // Create the main OutOfMinistryLeader record
        $outOfMinistryLeader = OutOfMinistryLeader::create([
            'leaders_count' => $request->leaders_count,
            'term_end' => $request->term_end,
            'user_id' => Auth::id(),
        ]);

        // Create OutOfMinistryLeaderDetail records for each leader
        foreach ($request->leaders as $leader) {
            OutOfMinistryLeaderDetail::create([
                'out_of_ministry_leader_id' => $outOfMinistryLeader->id,
                'leader_name' => $leader['leader_name'],
                'position' => $leader['position'],
                'gender' => $leader['gender'],
            ]);
        }

        return redirect()->route('out-of-ministry-leadership.index')
                         ->with('success', 'Out of Ministry Leaders created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OutOfMinistryLeader $outOfMinistryLeadership)
    {
        $this->authorizeLeaderAccess($outOfMinistryLeadership);
        $outOfMinistryLeadership->load(['user', 'outOfMinistryLeaderDetails']);
        return view('out-of-ministry-leadership.show', compact('outOfMinistryLeadership'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OutOfMinistryLeader $outOfMinistryLeadership)
    {
        $this->authorizeLeaderAccess($outOfMinistryLeadership);
        $outOfMinistryLeadership->load('outOfMinistryLeaderDetails');
        return view('out-of-ministry-leadership.edit', compact('outOfMinistryLeadership'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OutOfMinistryLeader $outOfMinistryLeadership)
    {
        $this->authorizeLeaderAccess($outOfMinistryLeadership);
        
        $request->validate([
            'leaders_count' => 'required|integer|min:1',
            'term_end' => 'required|date',
            'leaders' => 'required|array|min:1',
            'leaders.*.leader_name' => 'required|string|max:255',
            'leaders.*.position' => 'required|string|max:255',
            'leaders.*.gender' => 'required|in:male,female',
        ]);

        // Update the main OutOfMinistryLeader record
        $outOfMinistryLeadership->update([
            'leaders_count' => $request->leaders_count,
            'term_end' => $request->term_end,
        ]);

        // Delete existing leader details
        $outOfMinistryLeadership->outOfMinistryLeaderDetails()->delete();

        // Create new OutOfMinistryLeaderDetail records
        foreach ($request->leaders as $leader) {
            OutOfMinistryLeaderDetail::create([
                'out_of_ministry_leader_id' => $outOfMinistryLeadership->id,
                'leader_name' => $leader['leader_name'],
                'position' => $leader['position'],
                'gender' => $leader['gender'],
            ]);
        }

        return redirect()->route('out-of-ministry-leadership.index')
            ->with('success', 'Out of Ministry leadership information updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutOfMinistryLeader $outOfMinistryLeadership)
    {
        $this->authorizeLeaderAccess($outOfMinistryLeadership);
        
        $outOfMinistryLeadership->delete();

        return redirect()->route('out-of-ministry-leadership.index')
            ->with('success', 'Out of Ministry leadership information deleted successfully!');
    }
}
