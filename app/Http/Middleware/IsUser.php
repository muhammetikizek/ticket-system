<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('user')->check() && !auth()->user()->is_admin)
        {
            $request->headers->set('Accept', 'application/json');
            $request->headers->set('Content-Type', 'application/json');
            $request->headers->set('storeId', session('storeId'));
            dd($request);
            return $next($request);
        }
        return redirect()->route('login');
    }
}
