<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function create()
    {
        return view('reports.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('reports.index')->with('success', 'Report saved (demo).');
    }

    public function show($id)
    {
        return redirect()->route('reports.index')->with('info', 'Show report not implemented yet.');
    }

    public function edit($id)
    {
        return redirect()->route('reports.index')->with('info', 'Edit report not implemented yet.');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('reports.index')->with('success', 'Update report (demo).');
    }

    public function destroy($id)
    {
        return redirect()->route('reports.index')->with('success', 'Deleted report (demo).');
    }
}