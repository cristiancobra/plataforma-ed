<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Roles {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (Auth::user() == false) {
            return redirect('login');
        } elseif (Auth::user()->perfil == 'super administrador') {
            $role = "superadmin";
//                        $account->id != auth()->user()->account_id) {
//            echo "Você não possui permissão para acessar esta página.";
            ;
//            redirect()->back();
        } elseif (Auth::user()->perfil == 'dono') {
            $role = "dono";
        } elseif (Auth::user()->perfil == 'administrador') {
            $role = "administrator";
        } elseif (Auth::user()->perfil == 'funcionario') {
            $role = "employee";
        } elseif (Auth::user()->perfil == 'cliente') {
            $role = "customer";
        } else {
            return redirect('painel');
        }

        if ($request->route('account')) {
            echo 'tem account';
        } else {
            echo 'nao tem account';
        }
//                dd($request->route('account'))
        $request->merge([
            'role' => $role,
//                    'account_id' => auth()->user()->account_id,
        ]);

        return $next($request);
    }

}
