<?php

namespace App\Http\Controllers;

use App\Models\SkillVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SkillVideoController extends Controller
{
    public function index()
    {
        $videos = SkillVideo::latest()->get();
        return view('admin.skill-videos.index', compact('videos'));
    }

    public function create()
    {
        abort_unless(Auth::user()->role === 'admin', 403);
        return view('admin.skill-videos.create');
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'required|file|mimes:mp4,mov,avi,webm,mkv|max:51200',
        ]);

        $path = $request->file('video')->store('skills_videos', 'public');

        SkillVideo::create([
            'title' => $request->title,
            'description' => $request->description,
            'video_path' => $path,
            'is_active' => true,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.skill-videos.index')
            ->with('success', 'Video uploaded successfully.');
    }

    public function destroy(SkillVideo $skillVideo)
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        if ($skillVideo->video_path && Storage::disk('public')->exists($skillVideo->video_path)) {
            Storage::disk('public')->delete($skillVideo->video_path);
        }

        $skillVideo->delete();

        return redirect()->route('admin.skill-videos.index')
            ->with('success', 'Video deleted successfully.');
    }

    public function publicIndex()
    {
        $videos = SkillVideo::where('is_active', true)->latest()->get();
        return view('skill-videos.public', compact('videos'));
    }
}
