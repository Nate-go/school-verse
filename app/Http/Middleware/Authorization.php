<?php

namespace App\Http\Middleware;

use App\Constant\UserRole;
use App\Constant\UserStatus;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        if (Auth::user()->role != UserRole::ADMIN and Auth::user()->status != UserStatus::ACTIVE) {
            return redirect()->route('notPermission');
        }

        $roles = explode('|', $roles);
        if (in_array(Auth::user()['role'], $roles)) {
            return $next($request);
        }

        return redirect()->route('notPermission');
    }
}
