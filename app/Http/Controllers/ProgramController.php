<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        return view('programs.index');
    }

    public function create()
    {
        return view('programs.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('programs.index')->with('success', 'Program saved (demo).');
    }

    public function show($id)
    {
        return redirect()->route('programs.index')->with('info', 'Show program not implemented yet.');
    }

    public function edit($id)
    {
        return redirect()->route('programs.index')->with('info', 'Edit program not implemented yet.');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('programs.index')->with('success', 'Update program (demo).');
    }

    public function destroy($id)
    {
        return redirect()->route('programs.index')->with('success', 'Deleted program (demo).');
    }
}