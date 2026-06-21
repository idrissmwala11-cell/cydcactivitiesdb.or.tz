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
        $user = Auth::user();

        $homeVisitations = $this->scopeRecordsVisibleToUser(HomeVisitation::with('user'), $user)
            ->latest()
            ->paginate(15);

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
        $validated = $this->validateData($request);

        $validated['user_id'] = Auth::id();

        HomeVisitation::create($validated);

        return redirect()
            ->route('home-visitation.index')
            ->with('success', 'Home visitation information was saved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HomeVisitation $homeVisitation)
    {
        $this->authorizeUser($homeVisitation);

        $homeVisitation->load('user');

        return view('home-visitation.show', compact('homeVisitation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomeVisitation $homeVisitation)
    {
        $this->authorizeUser($homeVisitation);

        return view('home-visitation.edit', compact('homeVisitation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomeVisitation $homeVisitation)
    {
        $this->authorizeUser($homeVisitation);

        $validated = $this->validateData($request);

        $homeVisitation->update($validated);

        return redirect()
            ->route('home-visitation.show', $homeVisitation->id)
            ->with('success', 'Home visitation information was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomeVisitation $homeVisitation)
    {
        $this->authorizeUser($homeVisitation);

        $homeVisitation->delete();

        return redirect()
            ->route('home-visitation.index')
            ->with('success', 'Home visitation record was deleted successfully.');
    }

    /**
     * Validate request data
     */
    protected function validateData(Request $request): array
    {
        return $request->validate([
            'jina' => 'required|string|max:255',
            'namba' => 'required|string|max:255',
            'shule' => 'required|string|max:255',
            'darasa' => 'required|string|max:255',
            'last_program' => 'required|string|max:255',
            'likes_program' => 'required|string|in:Yes,No',
            'participant_comments' => 'nullable|string',
            'mtaa' => 'required|string|max:255',
            'mazingira' => 'required|string|max:255',
            'nyumba' => 'required|string|in:Owned,Loan,Rented',
            'paa' => 'required|string|in:Iron Sheets,Grass,Other',
            'choo' => 'required|string|in:Has Toilet,No Toilet',
            'milo' => 'required|string|in:1,2,3,More than 3',
            'wanaume' => 'required|integer|min:0',
            'wanawake' => 'required|integer|min:0',
            'tabia' => 'nullable|string',
            'visit_date' => 'required|date',
            'maoni' => 'nullable|string',
            'mtembelezaji' => 'required|string|max:255',
            'nafasi' => 'required|string|max:255',
        ]);
    }

    /**
     * Ensure the user is allowed to view or edit the record.
     */
    protected function authorizeUser(HomeVisitation $homeVisitation): void
    {
        $this->authorizeCenterRecord($homeVisitation, 'Huruhusiwi kuona taarifa za center nyingine.');
    }
}
