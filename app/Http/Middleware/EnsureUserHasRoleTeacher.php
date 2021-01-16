<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasRoleTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->user_type !== 2) {
            return redirect()->route('main')->with('success', 'Данный url доступен только для учителей');
        }

        return $next($request);
    }
}
