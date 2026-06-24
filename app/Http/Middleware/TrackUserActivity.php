<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TrackUserActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $lastTouchedAt = (int) $request->session()->get('last_seen_touched_at', 0);

            if (now()->timestamp - $lastTouchedAt >= 60) {
                DB::table('users')
                    ->where('id', Auth::id())
                    ->update(['last_seen_at' => now()]);

                $request->session()->put('last_seen_touched_at', now()->timestamp);
            }
        }

        return $next($request);
    }
}
