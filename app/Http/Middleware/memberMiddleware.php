<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class memberMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        if (
            !auth()->check() ||
            auth()->check() && auth()->user()->is_mamber) {
            return $next($request);
        }

        Alert::toast('Kamu bukan user', 'error');
        return redirect()->route('login');
    }
}

