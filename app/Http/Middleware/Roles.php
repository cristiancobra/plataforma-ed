<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		if(Auth::user()->perfil === 'administrador') {
			$role = "administrator";
		}
		if(Auth::user()->perfil === 'funcionario') {
			$role = "employee";
		}
		if(Auth::user()->perfil === 'cliente') {
			$role = "customer";
		}
		
		$request->merge(['role' => $role]);
		
        return $next($request);
    }
}
