<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        return view('skills.index');
    }

    public function create()
    {
        return view('skills.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('skills.index')->with('success', 'Skill saved (demo).');
    }

    public function show($id)
    {
        return redirect()->route('skills.index')->with('info', 'Show skill not implemented yet.');
    }

    public function edit($id)
    {
        return redirect()->route('skills.index')->with('info', 'Edit skill not implemented yet.');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('skills.index')->with('success', 'Update skill (demo).');
    }

    public function destroy($id)
    {
        return redirect()->route('skills.index')->with('success', 'Deleted skill (demo).');
    }
}