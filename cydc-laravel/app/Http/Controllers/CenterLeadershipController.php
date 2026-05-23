<?php

namespace App\Http\Controllers;

use App\Models\CenterLeadership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CenterLeadershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centerLeaderships = CenterLeadership::with('user')
            ->when(Auth::user()->role !== 'admin', function ($query) {
                return $query->where('user_id', Auth::id());
            })
            ->latest()
            ->paginate(10);
            
        return view('center-leadership.index', compact('centerLeaderships'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('center-leadership.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'center_name' => 'required|string|max:255',
            'leadership_list' => 'required|array|min:1',
            'leadership_list.*.namba' => 'required|string',
            'leadership_list.*.jina_la_kiongozi' => 'required|string',
            'leadership_list.*.namba_ya_kiongozi' => 'required|string',
            'leadership_list.*.cheo' => 'required|string',
            'challenges' => 'nullable|string',
            'feedback' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        CenterLeadership::create($validated);

        return redirect()->route('center-leadership.index')
            ->with('success', 'Taarifa za uongozi wa kituo zimehifadhiwa kikamilifu!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CenterLeadership $centerLeadership)
    {
        // Check if user can view this record
        if (Auth::user()->role !== 'admin' && $centerLeadership->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('center-leadership.show', compact('centerLeadership'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CenterLeadership $centerLeadership)
    {
        // Check if user can edit this record
        if (Auth::user()->role !== 'admin' && $centerLeadership->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('center-leadership.edit', compact('centerLeadership'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CenterLeadership $centerLeadership)
    {
        // Check if user can update this record
        if (Auth::user()->role !== 'admin' && $centerLeadership->user_id !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'center_name' => 'required|string|max:255',
            'leadership_list' => 'required|array|min:1',
            'leadership_list.*.namba' => 'required|string',
            'leadership_list.*.jina_la_kiongozi' => 'required|string',
            'leadership_list.*.namba_ya_kiongozi' => 'required|string',
            'leadership_list.*.cheo' => 'required|string',
            'challenges' => 'nullable|string',
            'feedback' => 'nullable|string',
        ]);

        $centerLeadership->update($validated);

        return redirect()->route('center-leadership.index')
            ->with('success', 'Taarifa za uongozi wa kituo zimesasishwa kikamilifu!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CenterLeadership $centerLeadership)
    {
        // Check if user can delete this record
        if (Auth::user()->role !== 'admin' && $centerLeadership->user_id !== Auth::id()) {
            abort(403);
        }
        
        $centerLeadership->delete();

        return redirect()->route('center-leadership.index')
            ->with('success', 'Taarifa za uongozi wa kituo zimefutwa kikamilifu!');
    }
    

}
