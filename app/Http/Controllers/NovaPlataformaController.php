<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helper;

class NovaPlataformaController extends Controller {

	public function modelo(Request $request)
	{
	$nome = ucfirst($request->novo_nome)." ".ucfirst($request->novo_sobrenome);
	$nome_usuario =  strtolower($request->novo_nome).".".strtolower($request->novo_sobrenome);
	$email = strtolower($request->novo_nome).".".strtolower($request->novo_sobrenome."@empresadigital.net.br");
	$dominio = strtolower($request->novo_nome).strtolower($request->novo_sobrenome."."."empresadigital.net.br");
	
	//if ($request->nova_senha != null) {
		$senha = $request->nova_senha;
	//}else{
	//	$senha = Helper::gerarSenha(8, true, true, true, true);
	//}
				
		return view('admin.NovaPlataforma.tutorial_plataforma', [
			'nome' => $nome,
			'nome_usuario' => $nome_usuario,
			'senha' => $senha,
			'email' => $email,
			'dominio' => $dominio,
		]);
	}
	
}