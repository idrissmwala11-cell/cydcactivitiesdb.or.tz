<?php

namespace App\Http\Controllers;

use App\Models\CenterLeadership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Auto-approve submissions.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'center_name' => ['required', 'string', 'max:255', 'not_regex:/^\d+$/'],
            'leadership_list' => 'required|array|min:1',
            'leadership_list.*.namba' => 'required|string',
            'leadership_list.*.jina_la_kiongozi' => 'required|string',
            'leadership_list.*.namba_ya_kiongozi' => 'required|string',
            'leadership_list.*.cheo' => 'required|string',
            'challenges' => 'nullable|string',
            'feedback' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'approved'; // <-- Auto-approve here

        CenterLeadership::create($validated);

        return redirect()->route('center-leadership.index')
            ->with('success', 'Center leadership information was saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CenterLeadership $centerLeadership)
    {
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
        if (Auth::user()->role !== 'admin' && $centerLeadership->user_id !== Auth::id()) {
            abort(403);
        }

        return view('center-leadership.edit', compact('centerLeadership'));
    }

    /**
     * Update the specified resource in storage.
     * Keep status approved automatically.
     */
    public function update(Request $request, CenterLeadership $centerLeadership)
    {
        if (Auth::user()->role !== 'admin' && $centerLeadership->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'center_name' => ['required', 'string', 'max:255', 'not_regex:/^\d+$/'],
            'leadership_list' => 'required|array|min:1',
            'leadership_list.*.namba' => 'required|string',
            'leadership_list.*.jina_la_kiongozi' => 'required|string',
            'leadership_list.*.namba_ya_kiongozi' => 'required|string',
            'leadership_list.*.cheo' => 'required|string',
            'challenges' => 'nullable|string',
            'feedback' => 'nullable|string',
        ]);

        $validated['status'] = 'approved'; // <-- Keep status approved

        $centerLeadership->update($validated);

        return redirect()->route('center-leadership.index')
            ->with('success', 'Center leadership information was updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CenterLeadership $centerLeadership)
    {
        if (Auth::user()->role !== 'admin' && $centerLeadership->user_id !== Auth::id()) {
            abort(403);
        }

        $centerLeadership->delete();

        return redirect()->route('center-leadership.index')
            ->with('success', 'Center leadership information was deleted successfully!');
    }

    /**
     * APPROVE CENTER LEADERSHIP (ADMIN ONLY)
     * You may keep this if you want manual approval for older pending records.
     */
    public function approve($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $centerLeadership = CenterLeadership::findOrFail($id);
        $centerLeadership->status = 'approved';
        $centerLeadership->save();

        return back()->with('success', 'Leadership information was approved successfully!');
    }
}
