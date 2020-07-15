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

// ------------------------------------------------ MARKETING - SITE  ------------------------------------------------
Route::get('/editarsite', 'SiteCliente@EditarSite')->name('editar-site');
Route::get('/postarsite', 'SiteCliente@PostarSite')->name('postar-site');

// --------------------------------------------- SUPORTE  --------------------

Route::get('/teste', function () {
	return view('teste');
});
Route::get('/arquivosdemkt', function () {
	return view('arquivosdemkt');
});



// ----------------------  Rotas do ADMIN ---------

Route::get('/admin/NovaPlataforma/form_plataforma', function () {
	return view('admin.NovaPlataforma.form_plataforma');
});

Route::get('/tutorial-plataforma', 'NovaPlataformaController@modelo')->name('tutorial_plataforma');

Route::get('/funil-vendas', function () {
	return view('admin.funil-vendas');
});

Route::get('/minhas-tarefas', function () {
	return view('tarefas.listAllTaskss');
});


// ================================ CRUD do USUÁRIO ===================

Route::resource('usuarios', 'Usuarios\\UserController')->names('user')->parameters(['usuarios' => 'user']);
