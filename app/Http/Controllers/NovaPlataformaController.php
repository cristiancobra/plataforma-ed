<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NovaPlataformaController extends Controller {

	public function modelo(Request $request)
	{
		
	$nome = $request->novo_nome.$request->novo_sobrenome;
	$senha = $request->nova_senha;
	$email = $request->novo_nome.".".$request->novo_sobrenome."@empresadigital.net.br";
		
		return view('admin.NovaPlataforma.tutorial_plataforma', [
			'nome' => $nome,
			'senha' => $senha,
			'email' => $email,
		]);
	}
}