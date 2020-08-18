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

// ================================ SISTEMA ===================
Auth::routes(['register' => false]);

Route::get('/', 'dashboardController@index')->name('home');

// ================================ ADMINISTRATIVO ===================
Route::get('/admin/NovaPlataforma/form_plataforma', function () {
	return view('admin.NovaPlataforma.form_plataforma');
});

Route::get('/tutorial-plataforma', 'NovaPlataformaController@modelo')->name('tutorial_plataforma');

Route::get('/funil-vendas', function () {
	return view('admin.funil-vendas');
});

// ================================ ACCOUNTS ===================
Route::resource('accounts', 'Accounts\\AccountController')->names('accounts')->parameters(['empresas' => 'accounts']);

// ================================ CONTATOS / CONTACTS ===================
Route::get('contacts', 'Contact\\ContactController@Index');

// ================================ EMAILS ===================
Route::resource('emails', 'Emails\\EmailController')->names('email');

// ================================ FACEBOOKS  ===================
Route::resource('facebooks', 'Socialmedia\\FacebookController')->names('facebook');

//Route::get('facebook', 'Socialmedia\\FacebookController@index')->name('facebook');
//Route::get('/facebook/callback', 'Socialmedia\\FacebookController@callback')->name('facebook-callback');
//Route::get('/facebook/callback', 'Socialmedia\\FacebookController@index')->name('facebook');

// ================================ INSTAGRAMS  ===================
Route::resource('instagrams', 'Socialmedia\\InstagramController')->names('instagram');

// ================================ MENU ===================
Route::get('/inicio', function () {
	return view('inicio');
});

Route::get('/logout', function () {
	Auth::logout();
	return Redirect::to('/');
});

// ------------------------------------------------ MINHA CONTA ------------------------------------------------
Route::get('/perfil', function () {
	return view('perfil');
});


// ------------------------------------------------ SOCIALMEDIA ------------------------------------------------
Route::get('/redes-sociais', function () {
	return view('socialmedia.workflowSocialmedia');
});

// ------------------------------------------------ REPORTS ------------------------------------------------
Route::get('/relatorios/{report}/pdf','ReportController@generatePDF')->name('report.pdf');
Route::resource('relatorios', 'ReportController')->names('report')->parameters(['relatorios' => 'report']);

// ------------------------------------------------ SITE  ------------------------------------------------
Route::get('/editarsite', 'SiteCliente@EditarSite')->name('editar-site');
Route::get('/postarsite', 'SiteCliente@PostarSite')->name('postar-site');

// ================================ TASKS ===================
Route::get('/minhas-tarefas', function () {
	return view('tarefas.listAllTasks');
});

// ================================ TRANSAÇÕES AKAUNTING ===================
Route::get('financeiro', 'Financial\\TransactionController@dashboard');
Route::resource('transactions', 'Financial\\TransactionController')->names('transaction')->parameters(['transacoes' => 'transaction']);

// ================================ USUÁRIO ===================
Route::resource('usuarios', 'Usuarios\\UserController')->names('user')->parameters(['usuarios' => 'user']);
