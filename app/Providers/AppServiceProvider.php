<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Announcement;
use App\Models\AnnouncementRead;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        App::setLocale(session('locale', config('app.locale')));

        View::composer('*', function ($view) {
            $latestAnnouncements = collect();
            $announcementCount = 0;
            $chatUnreadCount = 0;

            if (Schema::hasTable('announcements')) {
                $latestAnnouncements = Announcement::latest()->take(5)->get();
            }

            if (Auth::check() && Schema::hasTable('announcements') && Schema::hasTable('announcement_reads')) {
                $readAnnouncementIds = AnnouncementRead::where('user_id', Auth::id())
                    ->whereNotNull('read_at')
                    ->pluck('announcement_id');

                $announcementCount = Announcement::query()
                    ->when($readAnnouncementIds->isNotEmpty(), function ($query) use ($readAnnouncementIds) {
                        $query->whereNotIn('id', $readAnnouncementIds);
                    })
                    ->count();
            } elseif (Schema::hasTable('announcements')) {
                $announcementCount = Announcement::count();
            }

            if (Auth::check() && Schema::hasTable('chat_messages')) {
                $chatUnreadCount = ChatMessage::where('recipient_id', Auth::id())
                    ->whereNull('read_at')
                    ->count();
            }

            $view->with('latestAnnouncements', $latestAnnouncements)
                 ->with('announcementCount', $announcementCount)
                 ->with('chatUnreadCount', $chatUnreadCount);
        });
    }
}
