<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
        return view('sessions.index');
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('sessions.index')->with('success', 'Session saved (demo).');
    }

    public function show($id)
    {
        return redirect()->route('sessions.index')->with('info', 'Show session not implemented yet.');
    }

    public function edit($id)
    {
        return redirect()->route('sessions.index')->with('info', 'Edit session not implemented yet.');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('sessions.index')->with('success', 'Update session (demo).');
    }

    public function destroy($id)
    {
        return redirect()->route('sessions.index')->with('success', 'Deleted session (demo).');
    }
}