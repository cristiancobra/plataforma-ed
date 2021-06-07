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

Route::get('/', 'DashboardController@index')
		->name('dashboard')
		->middleware('roles');

//Route::get('/', 'Users\\UserController@dashboardAdministrator')->name('home.administrator')->middleware('administrator');
// ================================ ADMINISTRATIVO ===================
Route::get('/admin/NovaPlataforma/form_plataforma', function () {
	return view('admin.NovaPlataforma.form_plataforma');
});

Route::get('/tutorial-plataforma', 'NovaPlataformaController@modelo')->name('tutorial_plataforma');

Route::get('/funil-vendas', function () {
	return view('admin.funil-vendas');
});

// ================================ ACCOUNTS ===================
Route::resource('accounts', 'Accounts\\AccountController')
		->names('account')
		->parameters(['empresas' => 'accounts'])
		->middleware('roles');

// ================================ MARKET ===================
Route::resource('competitors', 'Market\\CompetitorController')->names('competitor')->parameters(['concorrentes' => 'competitors']);

// ================================ FINANCIAL ===================
//Route::resource('despesas', 'Financial\\BillController')
//		->except(['index'])
//		->names('bill')
//		->parameters(['despesas' => 'bill'])
//		->middleware('roles');

Route::resource('contas-bancarias', 'Financial\\BankAccountController')
		->names('bankAccount')
		->parameters(['contas-bancarias' => 'bankAccount'])
		->middleware('roles');

// faturas
Route::get('faturas/enviar', function () {
			return new \App\Mail\invoices();
		})
		->name('invoice.email')
		->middleware('roles');

Route::any('faturas/gerar/{invoice}', 'Financial\\InvoiceController@generateInstallment')
		->name('invoice.installment')
		->middleware('roles');

Route::get('faturas/pdf/{invoice}', 'Financial\\InvoiceController@createPDF')
		->name('invoice.pdf')
		->middleware('roles');

Route::any('/faturas/filtros', 'Financial\\InvoiceController@index')
		->name('invoice.index')
		->middleware('roles');

Route::any('faturas/gerar/{invoice}', 'Financial\\InvoiceController@generateInstallment')
		->name('invoice.installment')
		->middleware('roles');

Route::match(['get', 'post'], '/faturas/novo', 'Financial\\InvoiceController@create')
		->name('invoice.create')
		->middleware('roles');

Route::resource('faturas', 'Financial\\InvoiceController')
		->except([
			'index',
			'create'
		])
		->names('invoice')
		->parameters(['faturas' => 'invoice'])
		->middleware('roles');

// planejamento financeiro
Route::resource('planejamentos', 'Financial\\PlanningController')
		->names('planning')
		->parameters(['planejamentos' => 'planning'])
		->middleware('roles');

// dashboar financeiro
Route::get('financeiro', 'Financial\\TransactionController@dashboard');

// movimentações financeiras
Route::resource('movimentacoes', 'Financial\\TransactionController')
		->names('transaction')
		->parameters(['movimentacoes' => 'transaction'])
		->middleware('roles');

// =============================================== MARKETING ====================================
Route::resource('domains', 'Marketing\\DomainController')
		->names('domain')
		->parameters(['dominios' => 'domain']);

// emails
Route::post('emails/enviar/{email}', 'Emails\\EmailController@send')
		->name('email.send')
		->middleware('roles');

Route::resource('emails', 'Emails\\EmailController')
		->names('email')
		->middleware('roles');

//sites
Route::resource('sites', 'Marketing\\SiteController')
		->names('site')
		->middleware('roles');

//socialmedia
Route::resource('redes-sociais', 'Marketing\\SocialmediaController')
		->names('socialmedia')
		->parameters(['redes-sociais' => 'socialmedia'])
		->middleware('roles');

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

// ------------------------------------------------ OPERATIONAL  ------------------------------------------------
Route::any('/jornadas/filtros', 'Operational\\JourneyController@index')
		->name('journey.index')
		->middleware('roles');

Route::any('/jornadas/relatorios', 'Operational\\JourneyController@monthlyReport')
		->name('journey.reports')
		->middleware('roles');

Route::any('/jornadas/novo', 'Operational\\JourneyController@create')
		->name('journey.create')
		->middleware('roles');

Route::resource('jornadas', 'Operational\\JourneyController')
		->except(['index'])
		->names('journey')
		->parameters(['jornadas' => 'journey'])
		->middleware('roles');

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

Route::resource('relatorios', 'Report\\ReportController')
		->names('report')
		->parameters(['relatorios' => 'report'])
		->middleware('roles');

Route::resource('questoes', 'Report\\QuestionController')
		->names('question')
		->parameters(['questoes' => 'question'])
		->middleware('roles');

// =============================================== SALES ====================================
// contatos
Route::any('contatos/filtros', 'Contact\\ContactController@index')
		->name('contact.index')
		->middleware('roles');

Route::resource('contatos', 'Contact\\ContactController')
		->except(['index'])
		->names('contact')
		->parameters(['contatos' => 'contact'])
		->middleware('roles');

// contRatos
Route::get('contratos/pdf/{contract}', 'Sales\\ContractController@createPDF')
		->name('contract.pdf')
		->middleware('roles');

Route::resource('contratos', 'Sales\\ContractController')
		->names('contract')
		->parameters(['contratos' => 'contract'])
		->middleware('roles');

Route::resource('empresas', 'Sales\\CompanyController')
		->names('company')
		->parameters(['empresas' => 'company'])
		->middleware('roles');

Route::resource('modelos-de-contratos', 'Sales\\ContractTemplateController')
		->names('contractTemplate')
		->parameters(['modelos-de-contratos' => 'contractTemplate']);

Route::any('/oportunidades/filtros', 'Sales\\OpportunityController@filter')
		->name('opportunity.filter')
		->middleware('roles');

Route::resource('oportunidades', 'Sales\\OpportunityController')
		->names('opportunity')
		->parameters(['oportunidades' => 'opportunity'])
		->middleware('roles');

// products
Route::any('/produtos/filtros', 'Sales\\ProductController@filter')
		->name('product.filter')
		->middleware('roles');

Route::resource('produtos', 'Sales\\ProductController')
		->names('product')
		->parameters(['produtos' => 'product'])
		->middleware('roles');

// ------------------------------------------------ SITE  ------------------------------------------------
Route::get('/editarsite', 'SiteCliente@EditarSite')
		->name('editar-site');

Route::get('/postarsite', 'SiteCliente@PostarSite')
		->name('postar-site');

// ================================ TASKS ===================
Route::any('/tarefas/filtros', 'Tasks\\TaskController@filter')
		->name('task.filter')
		->middleware('roles');

Route::get('tarefas/pdf/{task}', 'Tasks\\TaskController@createPDF')
		->name('task.pdf')
		->middleware('roles');

//Route::match(['get', 'post'],
Route::match(['get', 'post'], 'tarefas/novo', 'Tasks\\TaskController@create')
		->name('task.create')
		->middleware('roles');

Route::resource('tarefas', 'Tasks\\TaskController')
		->except('create')
		->names('task')
		->parameters(['tarefas' => 'task'])
		->middleware('roles');

// ============================================== USERS =================================
Route::any('/usuarios/filtros', 'Users\\UserController@index')
		->name('user.index')
		->middleware('roles');

Route::resource('usuarios', 'Users\\UserController')
		->except(['index'])
		->names('user')
		->parameters(['usuarios' => 'user'])
		->middleware('roles');
