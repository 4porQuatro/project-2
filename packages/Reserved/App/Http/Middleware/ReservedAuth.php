<?php

namespace Packages\Reserved\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Packages\Reserved\App\Models\ReservedArea;

class ReservedAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $prefix = $request->route()->getPrefix();
        $reserved = ReservedArea::where('prefix', $prefix)->first();
        if(Auth::check() && Auth::user()->reserved_area_id == $reserved->id)
        {
           return $next($request);
        }
        return redirect()->to($reserved->loginPage->path());
    }
}
