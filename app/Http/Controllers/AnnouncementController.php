<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AnnouncementRead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Announcement::create([
            'user_id' => Auth::id(),
            'title'   => $request->title,
            'message' => $request->message,
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Ujumbe umetumwa kwa users wote.');
    }

    // 🔥 NEW: Show full message (FOR USER & ADMIN)
    public function show(Announcement $announcement)
    {
        if (Auth::check()) {
            AnnouncementRead::updateOrCreate(
                [
                    'announcement_id' => $announcement->id,
                    'user_id' => Auth::id(),
                ],
                [
                    'read_at' => now(),
                ]
            );
        }

        return view('announcements.show', compact('announcement'));
    }

    public function markAllRead()
    {
        abort_unless(Auth::check(), 403);

        $announcementIds = Announcement::pluck('id');

        foreach ($announcementIds as $announcementId) {
            AnnouncementRead::updateOrCreate(
                [
                    'announcement_id' => $announcementId,
                    'user_id' => Auth::id(),
                ],
                [
                    'read_at' => now(),
                ]
            );
        }

        $readAnnouncementIds = AnnouncementRead::where('user_id', Auth::id())
            ->whereNotNull('read_at')
            ->pluck('announcement_id');

        $unreadCount = Announcement::query()
            ->when($readAnnouncementIds->isNotEmpty(), function ($query) use ($readAnnouncementIds) {
                $query->whereNotIn('id', $readAnnouncementIds);
            })
            ->count();

        return response()->json([
            'success' => true,
            'unread_count' => $unreadCount,
        ]);
    }
}
