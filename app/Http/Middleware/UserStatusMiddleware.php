<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserStatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Allow admin users to access everything
            if ($user->isAdmin()) {
                return $next($request);
            }
            
            // Check user status
            switch ($user->status) {
                case 'pending':
                    // Redirect to pending approval page
                    if (!$request->routeIs('approval.pending') && !$request->routeIs('logout')) {
                        return redirect()->route('approval.pending');
                    }
                    break;
                    
                case 'rejected':
                    // Redirect to rejection page
                    if (!$request->routeIs('approval.rejected') && !$request->routeIs('logout') && !$request->routeIs('register')) {
                        return redirect()->route('approval.rejected');
                    }
                    break;
                    
                case 'approved':
                    // User is approved, allow access
                    break;
                    
                default:
                    // Default to pending if status is not set
                    if (!$request->routeIs('approval.pending') && !$request->routeIs('logout')) {
                        return redirect()->route('approval.pending');
                    }
                    break;
            }
        }
        
        return $next($request);
    }
}
