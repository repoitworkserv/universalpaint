<?php

namespace App\Http\Middleware;

use Closure;
use App\Role;
use Illuminate\Support\Facades\Route;

class UAC
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$moduleIndex)
    { 
        $role_id = auth()->user()->role_id;
        $role = Role::find($role_id);
        $UAC = explode(",",$role->permission);   

        if(strtolower($role->role_name) !== 'customer' && Route::currentRouteName() == "admin_profile") {
            return $next($request);
        }

        if(strtolower($role->role_name) == 'customer' || count($UAC) <= 0) {
            dd('test');
            auth('web')->logout();
            return redirect()->route('home');
        } else {
            if (!in_array($moduleIndex, $UAC))  {
                return redirect()->route('admin_profile')->with('status',"You are not authorized to access Dashboard page.");
            }
        }

        return $next($request);
    }
}
