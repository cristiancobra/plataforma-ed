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
Auth::routes(['register' => 'false']);

Route::get('/', 'DashboardController@index')
        ->name('dashboard')
        ->middleware('roles');

Route::get('/configuracoes', 'ConfigurationsController@index')
        ->name('configurations')
        ->middleware('roles');

Route::get('/tutorial-plataforma', 'NovaPlataformaController@modelo')->name('tutorial_plataforma');

Route::get('/clear', function () {
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('clear-compiled');
    return 'DONE';
});

// menu
Route::get('/inicio', function () {
    return view('inicio');
});

Route::get('/logout', function () {
    Auth::logout();
    return Redirect::to('/');
});

// ================================ ADMINISTRATIVO ===================
Route::get('/admin/NovaPlataforma/form_plataforma', function () {
    return view('admin.NovaPlataforma.form_plataforma');
});

Route::get('/funil-vendas', function () {
    return view('admin.funil-vendas');
});

// accounts
Route::get('contas/dashboard/{account}', 'Administrative\\Accounts\\AccountController@dashboard')
        ->name('account.dashboard')
        ->middleware('roles');

Route::resource('contas', 'Administrative\\Accounts\\AccountController')
        ->names('account')
        ->parameters(['contas' => 'account'])
        ->middleware('roles');

// users
Route::any('/usuarios/foto-perfil', 'Administrative\\Users\\UserController@storeProfilePicture')
        ->name('user.picture')
        ->middleware('roles');

Route::resource('usuarios', 'Administrative\\Users\\UserController')
        ->names('user')
        ->parameters(['usuarios' => 'user'])
        ->middleware('roles');

// ================================ FINANCIAL ===================
// banks
Route::resource('bancos', 'Financial\\BankController')
        ->names('bank')
        ->parameters(['bancos' => 'bank'])
        ->middleware('roles');

// banks accounts
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

Route::any('/faturas/filtros', 'Financial\\InvoiceController@filter')
        ->name('invoice.filter')
        ->middleware('roles');

Route::any('faturas/gerar/{invoice}', 'Financial\\InvoiceController@generateInstallment')
        ->name('invoice.installment')
        ->middleware('roles');

Route::match(['get', 'post'], '/faturas/novo', 'Financial\\InvoiceController@create')
        ->name('invoice.create')
        ->middleware('roles');

Route::resource('faturas', 'Financial\\InvoiceController')
        ->except([
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

// transactions / movimentações financeiras
Route::any('/movimentacoes/filtros', 'Financial\\TransactionController@filter')
        ->name('transaction.filter')
        ->middleware('roles');

Route::resource('movimentacoes', 'Financial\\TransactionController')
        ->names('transaction')
        ->parameters(['movimentacoes' => 'transaction'])
        ->middleware('roles');

// ================================ LIBRARIES ===================
// Images
Route::resource('biblioteca-imagens', 'Libraries\\ImageController')
        ->names('image')
        ->parameters(['biblioteca-imagens' => 'image'])
        ->middleware('roles');

// ================================ MARKET ===================
Route::resource('competitors', 'Market\\CompetitorController')
        ->names('competitor')
        ->parameters(['concorrentes' => 'competitors']);

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

// sites
Route::resource('sites', 'Marketing\\SiteController')
        ->names('site')
        ->middleware('roles');

//socialmedia
Route::resource('redes-sociais', 'Marketing\\SocialmediaController')
        ->names('socialmedia')
        ->parameters(['redes-sociais' => 'socialmedia'])
        ->middleware('roles');


// ------------------------------------------------ MINHA CONTA ------------------------------------------------
Route::get('/perfil', function () {
    return view('perfil');
});

// ------------------------------------------------ OPERATIONAL  ------------------------------------------------
Route::any('/jornadas/relatorios', 'Operational\\JourneyController@monthlyReport')
        ->name('journey.reports')
        ->middleware('roles');

Route::any('/jornadas/novo', 'Operational\\JourneyController@create')
        ->name('journey.create')
        ->middleware('roles');

Route::resource('jornadas', 'Operational\\JourneyController')
        ->names('journey')
        ->parameters(['jornadas' => 'journey'])
        ->middleware('roles');

// tasks
Route::get('tarefas/pdf/{task}', 'Operational\\TaskController@createPDF')
        ->name('task.pdf')
        ->middleware('roles');

Route::match(['get', 'post'], 'tarefas/novo', 'Operational\\TaskController@create')
        ->name('task.create')
        ->middleware('roles');

Route::resource('tarefas', 'Operational\\TaskController')
        ->except('create')
        ->names('task')
        ->parameters(['tarefas' => 'task'])
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

Route::get('relatorios/pdf/{report}', 'Administrative\\Report\\ReportController@createPDF')
        ->name('report.pdf')
        ->middleware('roles');

Route::resource('relatorios', 'Administrative\\Report\\ReportController')
        ->names('report')
        ->parameters(['relatorios' => 'report'])
        ->middleware('roles');

Route::resource('questoes', 'Administrative\\Report\\QuestionController')
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

// contRacts
Route::get('contratos/pdf/{contract}', 'Sales\\ContractController@createPDF')
        ->name('contract.pdf')
        ->middleware('roles');

Route::match(['get', 'post'], 'contratos/novo', 'Sales\\ContractController@create')
        ->name('contract.create')
        ->middleware('roles');

Route::resource('contratos', 'Sales\\ContractController')
        ->except('create')
        ->names('contract')
        ->parameters(['contratos' => 'contract'])
        ->middleware('roles');

//Companys
Route::resource('empresas', 'Sales\\CompanyController')
        ->names('company')
        ->parameters(['empresas' => 'company'])
        ->middleware('roles');

// contracts
Route::resource('modelos-de-contratos', 'Sales\\ContractTemplateController')
        ->names('contractTemplate')
        ->parameters(['modelos-de-contratos' => 'contractTemplate']);

// opportunities
Route::any('/oportunidades/filtros', 'Sales\\OpportunityController@filter')
        ->name('opportunity.filter')
        ->middleware('roles');

Route::get('/oportunidades/apagar/{opportunity}', 'Sales\\OpportunityController@trash')
        ->name('opportunity.trash')
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


