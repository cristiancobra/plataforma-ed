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
Auth::routes();

Route::get('/', 'Users\\UserController@dashboard')->name('home')->middleware('auth');

// ================================ ADMINISTRATIVO ===================
Route::get('/admin/NovaPlataforma/form_plataforma', function () {
	return view('admin.NovaPlataforma.form_plataforma');
});

Route::get('/tutorial-plataforma', 'NovaPlataformaController@modelo')->name('tutorial_plataforma');

Route::get('/funil-vendas', function () {
	return view('admin.funil-vendas');
});

// ================================ ACCOUNTS ===================
Route::resource('accounts', 'Accounts\\AccountController')->names('account')->parameters(['empresas' => 'accounts']);

// ================================ CONTATOS / CONTACTS ===================
Route::resource('contacts', 'Contact\\ContactController')->names('contact')->parameters(['contatos' => 'contacts']);

// ================================ MARKET ===================
Route::resource('competitors', 'Market\\CompetitorController')->names('competitor')->parameters(['concorrentes' => 'competitors']);

// ================================ EMAILS ===================
Route::resource('emails', 'Emails\\EmailController')->names('email');

// ================================ FINANCIAL ===================
Route::resource('oportunidades', 'Sales\\OpportunitieController')->names('opportunitie')->parameters(['oportunidades' => 'opportunitie']);
Route::resource('planejamentos', 'Financial\\PlanningController')->names('planning')->parameters(['planejamentos' => 'planning']);
Route::get('financeiro', 'Financial\\TransactionController@dashboard');
Route::resource('transactions', 'Financial\\TransactionController')->names('transaction')->parameters(['transacoes' => 'transaction']);

// =============================================== MARKETING ====================================
Route::resource('sites', 'Marketing\\SiteController')->names('site');
Route::resource('domains', 'Marketing\\DomainController')->names('domain')->parameters(['dominios' => 'domain']);

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


// ================================ SOCIALMEDIA ===================
//Route::get('/redes-sociais', function () {
//	return view('socialmedia.dashboardSocialmedia');
//});

Route::get('/redes-sociais', 'Socialmedia\\DashboardController@socialmedia')->name('socialmedia')->middleware('auth');

// ---------- FACEBOOKS
Route::get('/facebooks/all', 'Socialmedia\\FacebookController@all')->name('facebook.all');
Route::resource('facebooks', 'Socialmedia\\FacebookController')->names('facebook');
//Route::get('facebook', 'Socialmedia\\FacebookController@index')->name('facebook');
//Route::get('/facebook/callback', 'Socialmedia\\FacebookController@callback')->name('facebook-callback');
//Route::get('/facebook/callback', 'Socialmedia\\FacebookController@index')->name('facebook');

// ---------- INSTAGRAMS
Route::resource('instagrams', 'Socialmedia\\InstagramController')->names('instagram');

// ---------- LINKEDIN
Route::resource('linkedins', 'Socialmedia\\LinkedinController')->names('linkedin');

// ---------- TWITTER
Route::resource('twitter', 'Socialmedia\\TwitterController')->names('twitter');

// ---------- PINTEREST
Route::resource('pinterest', 'Socialmedia\\PinterestController')->names('pinterest');

// ---------- YOUTUBE
Route::resource('youtube', 'Socialmedia\\YoutubeController')->names('youtube');

// ---------- SPOTIFY
Route::resource('spotify', 'Socialmedia\\SpotifyController')->names('spotify');


// ------------------------------------------------ REPORTS ------------------------------------------------
//Route::get('/relatorios/{report}/pdf','Report\\ReportController@generatePDF')->name('report.pdf');
Route::post('/relatorios/facebook/{id}', 'Report\\ReportController@FB_save')->name('report.FB_save');
Route::post('/relatorios/instagram/{id}','Report\\ReportController@IG_save')->name('report.IG_save');
Route::post('/relatorios/linkedin/{id}','Report\\ReportController@IN_save')->name('report.IN_save');
Route::post('/relatorios/twitter/{id}','Report\\ReportController@TW_save')->name('report.TW_save');
Route::post('/relatorios/pinterest/{id}','Report\\ReportController@PI_save')->name('report.PI_save');
Route::post('/relatorios/youtube/{id}','Report\\ReportController@YT_save')->name('report.YT_save');
Route::post('/relatorios/spotify/{id}','Report\\ReportController@SP_save')->name('report.SP_save');
Route::resource('relatorios', 'Report\\ReportController')->names('report')->parameters(['relatorios' => 'report']);

// =============================================== SALES ====================================
Route::resource('contratos', 'Sales\\ContractController')->names('contract')->parameters(['contratos' => 'contract']);
Route::resource('oportunidades', 'Sales\\OpportunitieController')->names('opportunitie')->parameters(['oportunidades' => 'opportunitie']);
Route::resource('produtos', 'Sales\\ProductController')->names('product')->parameters(['produtos' => 'product']);

// ------------------------------------------------ SITE  ------------------------------------------------
Route::get('/editarsite', 'SiteCliente@EditarSite')->name('editar-site');
Route::get('/postarsite', 'SiteCliente@PostarSite')->name('postar-site');

// ================================ TASKS ===================
Route::any('/tarefas/filtros', 'Tasks\\TaskController@index')->name('task.index');
//Route::get('/tarefas/{order}', 'Tasks\\TaskController@order')->name('task.order');
Route::resource('tarefas', 'Tasks\\TaskController')->except(['index'])->names('task')->parameters(['tarefas' => 'task']);

// ============================================== USUÁRIO =================================
Route::resource('usuarios', 'Users\\UserController')->names('user')->parameters(['usuarios' => 'user']);

