<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isAdminOrPengelola
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role === 'Administrator' || Auth::user()->role === 'Pengelola') {
            return $next($request);
        }
        return redirect()->route('landing.page')->with('error', 'Anda tidak mempunyai akses ke halaman ini');
        // abort(403);
    }
}
