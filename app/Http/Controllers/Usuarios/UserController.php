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
		$user = Auth::user();
		if ($user->perfil == "administrador") {
			$users = User::all();
		}else{
			$users = User::where('id', '=', $user->id)->with('accounts')->get();
		}
		
		return view('usuarios.listAllUsers', [
			'users' => $users,
			'user' => $user,
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

		return view('usuarios.createUser', [
			'user' => $user,
			'newUser' => $newUser,
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
		$user->name = ucfirst($request->novo_nome) . " " . ucfirst($request->novo_sobrenome);
		$user->accounts = $request->account;
		$user->perfil = $request->perfil;
		$user->email = strtolower($request->novo_nome) . "." . strtolower($request->novo_sobrenome . "@empresadigital.net.br");
		$user->default_password = $request->password;
		$user->password = \Illuminate\Support\Facades\Hash::make($request->password);
		$user->dominio = strtolower($request->novo_nome) . strtolower($request->novo_sobrenome . "." . "empresadigital.net.br");
		$user->save();

		$nome_usuario = strtolower($request->novo_nome) . "." . strtolower($request->novo_sobrenome);

		return view('admin.NovaPlataforma.tutorial_plataforma', [
			'nome' => $user->name,
			'email' => $user->email,
			'senha' => $user->default_password,
			'dominio' => $user->dominio,
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
		$accounts = User::where('id', '=', $user->id)->with('accounts')->get();
		return view('usuarios.detailsUser', [
			'user' => $user,
			'accounts' => $accounts,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function edit(User $user) {
		$accounts = $user->accounts()->get();
		return view('usuarios.editUser', [
			'user' => $user,
			'accounts' => $accounts,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, User $user) {
		$user->name = $request->name;
		$user->email = $request->email;
		$user->accounts = $request->account;
		$user->dominio = $request->dominio;
		$user->perfil = $request->perfil;
		$user->default_password = $request->default_password;
		if (!empty($request->password)) {
			$user->password = \Illuminate\Support\Facades\Hash::make($request->password);
		}
		$user->save();

		return view('usuarios.detailsUser', [
			'user' => $user,
			'email' => $user->email,
			'password' => $user->default_password,
			'dominio' => $user->dominio,
				//'nome_usuario' => $nome_usuario,
		]);
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

	public function emails() {
		return $this->hasOne(App\Models\EmailModel::class, 'user_id', 'id');
	}

}
