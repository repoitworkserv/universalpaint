<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use App\Role;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     
    protected $auth;
	public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    public function handle($request, Closure $next)
    {
        $role = Role::find($this->auth->getUser()->role_id);
    	 if (strtolower($role->role_name) == "customer") {
    	 	\Session::flush();
    	 	\Auth::logout();
			return redirect('admin/signin')->with('status', 'These credentials is not allowed to access this site.');
            //abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
}
