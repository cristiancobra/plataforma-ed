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
		$userAuth = Auth::user();
		if ($userAuth->perfil == "administrador") {
			$users = User::where('id', '>=', 0)
					->with('accounts')
					->orderBy('NAME', 'asc')
					->paginate(5);
		} else {
			$users = User::whereHas('accounts', function ($query) {
						return $query->where('users.id', '=', Auth::user()->id)
						->with('accounts');
					})
					->get();
		}
		$totalUsers = $users
				->count();

		return view('usuarios.indexUsers', [
			'users' => $users,
			'userAuth' => $userAuth,
			'totalUsers' => $totalUsers,
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$user = new \App\User();
		$userAuth = Auth::user();

		return view('usuarios.createUser', [
			'user' => $user,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$userAuth = Auth::user();

		$user = new User();
		$user->name = ucfirst($request->novo_nome) . " " . ucfirst($request->novo_sobrenome);
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
			'userAuth' => $userAuth,
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
		$userAuth = Auth::user();

		if ($userAuth->perfil == "administrador") {
			$users = User::where('id', '>=', 0)
					->with('accounts')
					->orderBy('NAME', 'asc')
					->get();
		} else {
			$users = User::where('id', '=', $userAuth->id)
					->with('accounts')
					->get();
		}

		return view('usuarios.showUser', [
			'user' => $user,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function edit(User $user) {
		$userAuth = Auth::user();

		$accounts = $user->accounts()->get();
		return view('usuarios.editUser', [
			'user' => $user,
			'userAuth' => $userAuth,
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
		$userAuth = Auth::user();

		$user->name = $request->name;
		$user->email = $request->email;
		$user->dominio = $request->dominio;
		$user->perfil = $request->perfil;
		$user->default_password = $request->default_password;
		if (!empty($request->password)) {
			$user->password = \Illuminate\Support\Facades\Hash::make($request->password);
		}
		$user->save();

		return view('usuarios.showUser', [
			'user' => $user,
			'email' => $user->email,
			'password' => $user->default_password,
			'dominio' => $user->dominio,
			'userAuth' => $userAuth,
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
