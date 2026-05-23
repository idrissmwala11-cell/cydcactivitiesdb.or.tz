<?php

namespace App\Http\Controllers;

use App\Models\HomeVisitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeVisitationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $homeVisitations = HomeVisitation::with('user')->paginate(15);
        return view('home-visitation.index', compact('homeVisitations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('home-visitation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jina' => 'required|string|max:255',
            'namba' => 'required|string|max:255',
            'shule' => 'required|string|max:255',
            'darasa' => 'required|string|max:255',
            'last_program' => 'required|string|max:255',
            'likes_program' => 'required|string|in:Ndio,Hapana',
            'participant_comments' => 'nullable|string',
            'mtaa' => 'required|string|max:255',
            'mazingira' => 'required|string|max:255',
            'nyumba' => 'required|string|in:Yao,Mkopo,Mpangaji',
            'paa' => 'required|string|in:Bati,Nyasi,Nyingine',
            'choo' => 'required|string|in:Wanachoo,Hawana choo',
            'milo' => 'required|string|in:1,2,3,Zaidi ya 3',
            'wanaume' => 'required|integer|min:0',
            'wanawake' => 'required|integer|min:0',
            'tabia' => 'nullable|string',
            'visit_date' => 'required|date',
            'maoni' => 'nullable|string',
            'mtembelezaji' => 'required|string|max:255',
            'nafasi' => 'required|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();
        
        HomeVisitation::create($validated);
        
        return redirect()->route('home-visitation.create')
            ->with('success', 'Home visitation record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HomeVisitation $homeVisitation)
    {
        return view('home-visitation.show', compact('homeVisitation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomeVisitation $homeVisitation)
    {
        return view('home-visitation.edit', compact('homeVisitation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomeVisitation $homeVisitation)
    {
        $validated = $request->validate([
            'jina' => 'required|string|max:255',
            'namba' => 'required|string|max:255',
            'shule' => 'required|string|max:255',
            'darasa' => 'required|string|max:255',
            'last_program' => 'required|string|max:255',
            'likes_program' => 'required|string|in:Ndio,Hapana',
            'participant_comments' => 'nullable|string',
            'mtaa' => 'required|string|max:255',
            'mazingira' => 'required|string|max:255',
            'nyumba' => 'required|string|in:Yao,Mkopo,Mpangaji',
            'paa' => 'required|string|in:Bati,Nyasi,Nyingine',
            'choo' => 'required|string|in:Wanachoo,Hawana choo',
            'milo' => 'required|string|in:1,2,3,Zaidi ya 3',
            'wanaume' => 'required|integer|min:0',
            'wanawake' => 'required|integer|min:0',
            'tabia' => 'nullable|string',
            'visit_date' => 'required|date',
            'maoni' => 'nullable|string',
            'mtembelezaji' => 'required|string|max:255',
            'nafasi' => 'required|string|max:255',
        ]);
        
        $homeVisitation->update($validated);
        
        return redirect()->route('home-visitation.index')
            ->with('success', 'Home visitation record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomeVisitation $homeVisitation)
    {
        $homeVisitation->delete();
        
        return redirect()->route('home-visitation.index')
            ->with('success', 'Home visitation record deleted successfully.');
    }
}
