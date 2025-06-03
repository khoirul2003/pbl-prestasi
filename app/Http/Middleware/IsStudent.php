<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsStudent
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role->role_name === 'Student') {
            return $next($request);
        }
        abort(403);
    }
}
