<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index()
    {
        return view('participants.index');
    }

    public function create()
    {
        return view('participants.create');
    }

    public function store(Request $request)
    {
        // Placeholder store logic (no persistence yet)
        return redirect()->route('participants.index')->with('success', 'Participant saved (demo).');
    }

    public function show($id)
    {
        return redirect()->route('participants.index')->with('info', 'Show participant not implemented yet.');
    }

    public function edit($id)
    {
        return redirect()->route('participants.index')->with('info', 'Edit participant not implemented yet.');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('participants.index')->with('success', 'Update participant (demo).');
    }

    public function destroy($id)
    {
        return redirect()->route('participants.index')->with('success', 'Deleted participant (demo).');
    }
}