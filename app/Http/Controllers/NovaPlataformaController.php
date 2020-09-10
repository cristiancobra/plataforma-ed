<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Helper;

class NovaPlataformaController extends Controller {

	public function modelo(User $user) {
		$userAuth = Auth::user();		
		$user = $user;

		if (Auth::check()) {

			$nome_usuario = "teste.testador";
			
			$senha = "123";


			return view('admin.NovaPlataforma.tutorial_plataforma', [
				'userAuth' => $userAuth,
				'user' => $user,
				'nome_usuario' => $nome_usuario,
				'senha' => $senha,
			]);
		} else {
			return redirect('/');
		}
	}

}
