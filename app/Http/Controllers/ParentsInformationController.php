<?php

namespace App\Http\Controllers;

use App\Models\ParentsInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentsInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $parentsInformation = $this->scopeRecordsVisibleToUser(ParentsInformation::with('user'), $user)
            ->latest()
            ->paginate(15);

        return view('parents-information.index', compact('parentsInformation'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('parents-information.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_name' => 'required|string|max:255',
            'parent_of' => 'required|string|max:255',
            'activity' => 'required|string|max:255',
            'support_type' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'parent_comments' => 'nullable|string',
            'supervisor_comments' => 'nullable|string',
            'submission_date' => 'required|date',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'approved';

        ParentsInformation::create($validated);

        return redirect()->route('parents-information.index')
            ->with('success', 'Parent information saved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ParentsInformation $parentsInformation)
    {
        $this->authorizeCenterRecord($parentsInformation);

        return view('parents-information.show', compact('parentsInformation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParentsInformation $parentsInformation)
    {
        $this->authorizeCenterRecord($parentsInformation);

        return view('parents-information.edit', compact('parentsInformation'));
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, ParentsInformation $parentsInformation)
    {
        $this->authorizeCenterRecord($parentsInformation);

        $validated = $request->validate([
            'parent_name' => 'required|string|max:255',
            'parent_of' => 'required|string|max:255',
            'activity' => 'required|string|max:255',
            'support_type' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'parent_comments' => 'nullable|string',
            'supervisor_comments' => 'nullable|string',
            'submission_date' => 'required|date',
        ]);

        $parentsInformation->update($validated);

        return redirect()->route('parents-information.index')
            ->with('success', 'Parent information updated successfully.');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(ParentsInformation $parentsInformation)
    {
        $this->authorizeCenterRecord($parentsInformation);

        $parentsInformation->delete();

        return redirect()->route('parents-information.index')
            ->with('success', 'Parent information deleted successfully.');
    }
}
