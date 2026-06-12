<?php

namespace App\Http\Controllers;

use App\Models\ClusterLeader;
use App\Models\ClusterLeaderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClusterLeaderController extends Controller
{
    protected function authorizeLeaderAccess(ClusterLeader $clusterLeader): void
    {
        if (Auth::user()->role !== 'admin' && $clusterLeader->user_id !== Auth::id()) {
            abort(403);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clusterLeaders = ClusterLeader::with(['user', 'leaderDetails'])
            ->when(Auth::user()->role !== 'admin', function ($query) {
                return $query->where('user_id', Auth::id());
            })
            ->latest()
            ->paginate(10);
            
        return view('cluster-leadership.index', compact('clusterLeaders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cluster-leadership.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cluster_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'term_end' => 'required|date',
            'leaders' => 'required|array|min:1',
            'leaders.*.leader_name' => 'required|string|max:255',
            'leaders.*.leader_id' => 'required|string|max:255',
            'leaders.*.leader_position' => 'required|string|max:255'
        ]);

        $validated['user_id'] = Auth::id();
        
        // Create the cluster leader record
        $clusterLeader = ClusterLeader::create([
            'cluster_name' => $validated['cluster_name'],
            'yds_name' => $validated['location'], // Map location to yds_name
            'leadership_term' => $validated['term_end'], // Map term_end to leadership_term
            'leader_count' => count($validated['leaders']), // Set leader count
            'meeting_count' => '0', // Default value
            'gethro_practice' => 'N/A', // Default value
            'user_id' => $validated['user_id']
        ]);
        
        // Create cluster leader details
        foreach ($validated['leaders'] as $leader) {
            $clusterLeader->leaderDetails()->create([
                'leader_name' => $leader['leader_name'],
                'leader_id' => $leader['leader_id'],
                'leader_position' => $leader['leader_position'],
                'user_id' => Auth::id()
            ]);
        }

        return redirect()->route('cluster-leadership.index')
            ->with('success', 'Cluster leadership information saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClusterLeader $clusterLeadership)
    {
        $this->authorizeLeaderAccess($clusterLeadership);
        $clusterLeadership->load(['user', 'leaderDetails']);
        return view('cluster-leadership.show', compact('clusterLeadership'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClusterLeader $clusterLeadership)
    {
        $this->authorizeLeaderAccess($clusterLeadership);
        $clusterLeadership->load('leaderDetails');
        return view('cluster-leadership.edit', compact('clusterLeadership'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClusterLeader $clusterLeadership)
    {
        $this->authorizeLeaderAccess($clusterLeadership);
        
        $validated = $request->validate([
            'cluster_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'term_end' => 'required|date',
            'leaders' => 'required|array|min:1',
            'leaders.*.leader_name' => 'required|string|max:255',
            'leaders.*.leader_id' => 'required|string|max:255',
            'leaders.*.leader_position' => 'required|string|max:255'
        ]);

        // Update the cluster leader record
        $clusterLeadership->update([
            'cluster_name' => $validated['cluster_name'],
            'yds_name' => $validated['location'], // Map location to yds_name
            'leadership_term' => $validated['term_end'], // Map term_end to leadership_term
            'leader_count' => count($validated['leaders']) // Update leader count
        ]);
        
        // Delete existing leader details and create new ones
        $clusterLeadership->leaderDetails()->delete();
        
        foreach ($validated['leaders'] as $leader) {
            $clusterLeadership->leaderDetails()->create([
                'leader_name' => $leader['leader_name'],
                'leader_id' => $leader['leader_id'],
                'leader_position' => $leader['leader_position'],
                'user_id' => Auth::id()
            ]);
        }

        return redirect()->route('cluster-leadership.index')
            ->with('success', 'Cluster leadership information updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClusterLeader $clusterLeadership)
    {
        $this->authorizeLeaderAccess($clusterLeadership);
        
        $clusterLeadership->delete();

        return redirect()->route('cluster-leadership.index')
            ->with('success', 'Cluster leadership information deleted successfully!');
    }
}
