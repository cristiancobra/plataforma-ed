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
		if(Auth::user() == false){
			return redirect('login');
		}
		elseif(Auth::user()->perfil == 'super administrador') {
			$role = "superadmin";
		}
		elseif(Auth::user()->perfil == 'dono') {
			$role = "dono";
		}
		elseif(Auth::user()->perfil == 'administrador') {
			$role = "administrator";
		}
		elseif(Auth::user()->perfil == 'funcionario') {
			$role = "employee";
		}
		elseif(Auth::user()->perfil == 'cliente') {
			$role = "customer";
		}else{
			return redirect('painel');
		}
		
		$request->merge(['role' => $role]);
		
        return $next($request);
    }
}
