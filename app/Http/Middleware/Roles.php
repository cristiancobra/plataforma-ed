<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;

class Roles {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        
//        Define o perfil do usuário
        if (Auth::user() == false) {
            return redirect('login');
        } elseif (Auth::user()->perfil == 'super administrador') {
            $role = "superadmin";
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
        
//        Verifica se o usuário tem logo e cores da empresa
        $empresaDigital = Account::find(1);
        
         if(auth()->user()->account->image) {
             $logo = auth()->user()->account->image->path;
         }else{
             $logo = $empresaDigital->image->path;
         }
         
         if(auth()->user()->account->principal_color) {
             $principalColor = auth()->user()->account->principal_color;
         }else{
             $principalColor = $empresaDigital->principal_color;
         }

         if(auth()->user()->account->complementary_color) {
             $complementaryColor = auth()->user()->account->complementary_color;
         }else{
             $complementaryColor = $empresaDigital->complementary_color;
         }
         
         if(auth()->user()->account->opposite_color) {
             $oppositeColor = auth()->user()->account->opposite_color;
         }else{
             $oppositeColor = $empresaDigital->opposite_color;
         }

// verifica se o usuário tem permissão para acessar a rota
        if ($request->route('account')) {
            $account = $request->route('account');
            $accountId = $account->id;
        } else {
            $accountId = auth()->user()->account_id;
        }
        
        if($accountId != auth()->user()->account_id) {
             abort(403);
        }

//        Adiciona as variáveis no request e dá proseguimento
        $request->merge([
            'role' => $role,
//            'logo' => $logo,
//            'principalColor' => $principalColor,
//            'complementaryColor' => $complementaryColor,
//            'oppositeColor' => $oppositeColor,
        ]);

        return $next($request);
    }

}
