<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupMemberController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'GroupMember disabled']);
    }

    public function create()
    {
        return redirect()->back()->with('error', 'Feature disabled');
    }

    public function store(Request $request)
    {
        return redirect()->back()->with('error', 'Feature disabled');
    }

    public function show($id)
    {
        return redirect()->back()->with('error', 'Feature disabled');
    }

    public function edit($id)
    {
        return redirect()->back()->with('error', 'Feature disabled');
    }

    public function update(Request $request, $id)
    {
        return redirect()->back()->with('error', 'Feature disabled');
    }

    public function destroy($id)
    {
        return redirect()->back()->with('error', 'Feature disabled');
    }
}
