<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FormTwoResultsAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless($request->user()?->canAccessFormTwoResults(), 403, 'Huna ruhusa ya kutumia mfumo wa matokeo ya Form Two.');

        return $next($request);
    }
}
