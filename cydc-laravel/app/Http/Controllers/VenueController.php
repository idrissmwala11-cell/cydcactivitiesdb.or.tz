<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index()
    {
        return view('venues.index');
    }

    public function create()
    {
        return view('venues.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('venues.index')->with('success', 'Venue saved (demo).');
    }

    public function show($id)
    {
        return redirect()->route('venues.index')->with('info', 'Show venue not implemented yet.');
    }

    public function edit($id)
    {
        return redirect()->route('venues.index')->with('info', 'Edit venue not implemented yet.');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('venues.index')->with('success', 'Update venue (demo).');
    }

    public function destroy($id)
    {
        return redirect()->route('venues.index')->with('success', 'Deleted venue (demo).');
    }
}