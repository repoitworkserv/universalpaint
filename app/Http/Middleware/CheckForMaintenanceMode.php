<?php

namespace App\Http\Middleware;

use App\Settings;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class CheckForMaintenanceMode
{
    protected $request;

    protected $app;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $settings = Settings::first();
        if ($settings->mode == 'under_maintenance' && (!$request->is('admin') && !$request->is('admin/*') && !$request->is('logout'))) {
            \Session::flush();
            \Auth::logout();
            return view('errors.503');
        }
        return $next($request);
    }
}
