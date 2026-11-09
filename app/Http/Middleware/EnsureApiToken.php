<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/** Sends visitors without an API token to the login page before they fill in a form. */
class EnsureApiToken
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('api_token')) {
            return redirect()->guest(route('login'));
        }

        return $next($request);
    }
}
