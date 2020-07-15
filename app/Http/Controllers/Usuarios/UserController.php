<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$users = User::all();

		return view('admin.Usuarios.listAllUsers', [
			'users' => $users
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$newUser = new \App\User();
		$user = Auth::user();
		$newUser->gerarSenha(6, true, true, true, true);

		return view('admin.Usuarios.createUser', [
			'user' => $user,
			'senha' => $newUser,
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$user = new User();
		$user->name = ucfirst($request->novo_nome)." ".ucfirst($request->novo_sobrenome);
		$user->email = strtolower($request->novo_nome).".".strtolower($request->novo_sobrenome."@empresadigital.net.br");
		$user->password = \Illuminate\Support\Facades\Hash::make($request->password);
		$user->save();
		
		$dominio = strtolower($request->novo_nome).strtolower($request->novo_sobrenome."."."empresadigital.net.br");
		$nome_usuario =  strtolower($request->novo_nome).".".strtolower($request->novo_sobrenome);

		return view('admin.NovaPlataforma.tutorial_plataforma', [
			'nome' => $user->name,
			'email' => $user->email,
			'senha' => $user->password,
			'dominio' => $dominio,
			'nome_usuario' => $nome_usuario,
		]);
	}
	
	//	$nome = ucfirst($request->novo_nome)." ".ucfirst($request->novo_sobrenome);
	// $nome_usuario =  strtolower($request->novo_nome).".".strtolower($request->novo_sobrenome);
//	$email = strtolower($request->novo_nome).".".strtolower($request->novo_sobrenome."@empresadigital.net.br");
//	$dominio = strtolower($request->novo_nome).strtolower($request->novo_sobrenome."."."empresadigital.net.br");
	
	
	
	

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function show(User $user) {
		return view('admin.Usuarios.detailsUser', [
			'user' => $user
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function edit(User $user) {
		var_dump($user);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, User $user) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user) {
		$user->delete();
		return redirect()->route('user.index');
	}

}
