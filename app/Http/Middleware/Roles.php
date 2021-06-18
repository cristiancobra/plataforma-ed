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
            $account = $request->route('account');
            $accountId = $account->id;
        } else {
            $accountId = auth()->user()->account_id;
        }
        
        if($accountId != auth()->user()->account_id) {
             abort(403);
        }

//        if ($request->route('account')->get('')) {
//            $account = $request->route('account');
//            $accountId = $account->id;
//        }else{
//            $accountId = 0;
//        }
//        if ($request->route('user')) {
//            $user = $request->route('user');
//            $userId = $user->id;
//        }else{
//            $userId = 0;
//        }
//        if ($accountId != auth()->user()->account_id) {
//            echo 'account é nulo ou igual';
//            }
//        } elseif ($user->id != null OR $user->id != auth()->user()->user_id) {
//            echo 'USER é nulo ou igual';
//        } else {
        $request->merge([
            'role' => $role,
        ]);

        return $next($request);
    }

}
