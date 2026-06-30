<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles) {
        if(in_array($request->user()->role, $roles)) {
            return $next($request);
        }
        abort(403);
    }
}