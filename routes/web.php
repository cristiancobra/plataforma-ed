<?php

use Illuminate\Support\Facades\Route;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */


Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('home');

Route::get('/logout', function () {
	Auth::logout();
	return Redirect::to('/');
});

// ================================ ROTA DO MENU ===================
// ------------------------------------------------ INÍCIO --------------------

Route::get('/inicio', function () {
	return view('inicio');
});

// ------------------------------------------------ MINHA CONTA ------------------------------------------------

Route::get('/perfil', function () {
	return view('perfil');
});

Route::get('/gerenciador-financeiro', function () {
	return view('gerenciador-financeiro');
});

// ------------------------------------------------ VENDAS  ------------------------------------------------

Route::get('/novopotencial', function () {
	return view('novopotencial');
});
// ------------------------------------------------ MARKETING  ------------------------------------------------

Route::get('/marketing', function () {
	return view('marketing');
});

Route::get('/editarsite', 'SiteCliente@EditarSite')->name('editar-site');
Route::get('/postarsite', 'SiteCliente@PostarSite')->name('postar-site');

Route::get('/novacampanha', function () {
	return view('novacampanha');
});

Route::get('/novalista', function () {
	return view('novalista');
});

// -------------- SUPORTE  --------------------
// -------------- SAIR  --------------------

Route::get('/crm', function () {
	return view('crm');
});

Route::get('/oportunidades', function () {
	return view('oportunidades');
});

Route::get('/nuvem', function () {
	return Redirect::to('https://nuvem.empresadigital.net.br');
});



Route::get('/suporte', function () {
	return view('suporte');
});





Route::get('/teste', function () {
	return view('teste');
});

Route::get('/arquivosdemkt', function () {
	return view('arquivosdemkt');
});

Route::get('/banco', function () {
	return view('banco');
});

Route::get('/favoritos', function () {
	return view('favoritos');
});
Route::get('/novafatura', function () {
	return view('novafatura');
});
Route::get('/novaoportunidade', function () {
	return view('novaoportunidade');
});

Route::get('/novareuniao', function () {
	return view('novareuniao');
});

Route::get('/novatarefa', function () {
	return view('novatarefa');
});

Route::get('/novoprojeto', function () {
	return view('novoprojeto');
});

Route::get('/orcamento', function () {
	return view('orcamento');
});

Route::get('/registrardespesas', function () {
	return view('registrarpagamento');
});

Route::get('/tarefadeprojeto', function () {
	return view('tarefadeprojeto');
});



// ----------------------  Rotas do ADMIN ---------

Route::get('/admin/NovaPlataforma/form_plataforma', function () {
	return view('admin.NovaPlataforma.form_plataforma');
	});

Route::get('/tutorial-plataforma','NovaPlataformaController@modelo')->name('tutorial_plataforma');

Route::get('/funil-vendas', function () {
	return view('admin.funil-vendas');
});

Route::get('/minhas-tarefas', function () {
	return view('tarefas.listAllTaskss');
});


// ================================ CRUD do USUÁRIO ===================

Route::resource('usuarios', 'Usuarios\\UserController')->names('user')->parameters(['usuarios' => 'user']);
