<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    use \App\Traits\AdminPermission;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->checkRequestPermission()) {
            return response()->view('backend.layouts.dashboard');
        }
        return $next($request);
    }


    // public function handle(Request $request, Closure $next)
    // {
    //     $response = $this->checkRequestPermission();
    //     if ($response) {
    //         return $response;
    //     }

    //     return $next($request);
    // }
}
