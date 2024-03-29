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

// panels

Route::get('/administrativo', 'DashboardController@administrative')
        ->name('dashboard.administrative')
        ->middleware('roles');


Route::get('/desenvolvimento', 'DashboardController@development')
        ->name('dashboard.development')
        ->middleware('roles');

Route::get('/financeiro', 'DashboardController@financial')
        ->name('dashboard.financial')
        ->middleware('roles');

Route::get('/marketing', 'DashboardController@marketing')
        ->name('dashboard.marketing')
        ->middleware('roles');

Route::get('/', 'DashboardController@operational')
        ->name('dashboard.operational')
        ->middleware([
            'redirect_domain',
            'roles',
        ]);

Route::get('/vendas', 'DashboardController@sales')
        ->name('dashboard.sales')
        ->middleware('roles');

Route::get('/plataforma', 'DashboardController@plataforma')
        ->name('dashboard.plataforma')
        ->middleware('roles');

Route::get('/suporte', 'DashboardController@support')
        ->name('dashboard.support')
        ->middleware('roles');

// ////


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

Route::get('/tutoriais', 'System\\SystemTextsController@tutorial')->name('systemText.indexTutorials');

Route::get('/tutoriais/{systemText}', 'System\\SystemTextsController@showTutorial')->name('systemText.showTutorial');

Route::resource('textos-do-sistema', 'System\\SystemTextsController')
        ->names('systemText')
        ->parameters(['textos-do-sistema' => 'systemText'])
        ->middleware('roles');


Route::get('/configuracoes', 'ConfigurationsController@index')
        ->name('configurations')
        ->middleware('roles');

// ================================ ADMINISTRATIVO ===================
//Route::get('/admin/NovaPlataforma/form_plataforma', function () {
//    return view('admin.NovaPlataforma.form_plataforma');
//});
//
//Route::get('/funil-vendas', function () {
//    return view('admin.funil-vendas');
//});
// accounts
Route::get('contas/dashboard/{account}', 'Administrative\\Accounts\\AccountController@dashboard')
        ->name('account.dashboard')
        ->middleware('roles');

Route::get('contas/liberar/{account}', 'Administrative\\Accounts\\AccountController@allowAccount')
        ->name('account.allow')
        ->middleware('roles');

Route::get('contas/report', 'Administrative\\Accounts\\AccountController@report')
        ->name('account.report')
        ->middleware('roles');

Route::resource('contas', 'Administrative\\Accounts\\AccountController')
        ->names('account')
        ->parameters(['contas' => 'account'])
        ->middleware('roles');

// users
Route::any('/usuarios/foto-perfil', 'Administrative\\Users\\UserController@storeProfilePicture')
        ->name('user.picture')
        ->middleware('roles');

Route::get('usuarios/report', 'Administrative\\Users\\UserController@report')
        ->name('user.report')
        ->middleware('roles');

Route::resource('usuarios', 'Administrative\\Users\\UserController')
        ->names('user')
        ->parameters(['usuarios' => 'user'])
        ->middleware('roles');

// goals
Route::put('/metas/apagar/{goal}', 'Administrative\\GoalController@sendToTrash')
        ->name('goal.trash')
        ->middleware('roles');

Route::put('/metas/restaurar/{goal}', 'Administrative\\GoalController@restoreFromTrash')
        ->name('goal.restore')
        ->middleware('roles');

Route::resource('metas', 'Administrative\\GoalController')
        ->names('goal')
        ->parameters(['metas' => 'goal'])
        ->middleware('roles');

// stages
Route::put('/etapas/apagar/{stage}', 'Operational\\StageController@sendToTrash')
        ->name('stage.trash')
        ->middleware('roles');

Route::put('/etapas/restaurar/{stage}', 'Operational\\StageController@restoreFromTrash')
        ->name('stage.restore')
        ->middleware('roles');

Route::resource('etapas', 'Operational\\StageController')
        ->names('stage')
        ->parameters(['etapas' => 'stage'])
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

Route::any('/faturas/relatorio', 'Financial\\InvoiceController@report')
        ->name('invoice.report')
        ->middleware('roles');

Route::get('faturas/relatorio/pdf', 'Financial\\InvoiceController@createPdfReport')
        ->name('invoice.pdfReport')
        ->middleware('roles');

Route::get('faturas/pdf/{invoice}', 'Financial\\InvoiceController@createPdf')
        ->name('invoice.pdf')
        ->middleware('roles');

//Route::any('/faturas/filtros', 'Financial\\InvoiceController@filter')
//        ->name('invoice.filter')
//        ->middleware('roles');

//Route::any('faturas/gerar/{invoice}', 'Financial\\InvoiceController@generateInstallment')
//        ->name('invoice.installment')
//        ->middleware('roles');

Route::put('/faturas/apagar/{invoice}', 'Financial\\InvoiceController@sendToTrash')
        ->name('invoice.trash')
        ->middleware('roles');


Route::put('/faturas/restaurar/{invoice}', 'Financial\\InvoiceController@restoreFromTrash')
        ->name('invoice.restore')
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
Route::put('/planejamentos/apagar/{planning}', 'Administrative\\PlanningController@sendToTrash')
        ->name('planning.trash')
        ->middleware('roles');

Route::put('/planejamentos/restaurar/{planning}', 'Administrative\\PlanningController@restoreFromTrash')
        ->name('planning.restore')
        ->middleware('roles');

Route::resource('planejamentos', 'Administrative\\PlanningController')
        ->names('planning')
        ->parameters(['planejamentos' => 'planning'])
        ->middleware('roles');


// transactions / movimentações financeiras
Route::post('/movimentacoes/adicionar', 'Financial\\TransactionController@storeFromOpportunity')
        ->name('transaction.storeOpportunity');

Route::put('/movimentacoes/apagar/{transaction}', 'Financial\\TransactionController@sendToTrash')
        ->name('transaction.trash')
        ->middleware('roles');

Route::put('/movimentacoes/restaurar/{transaction}', 'Financial\\TransactionController@restoreFromTrash')
        ->name('transaction.restore')
        ->middleware('roles');

Route::get('/movimentacoes/export-csv', 'Financial\\TransactionController@exportCsv')
        ->name('transaction.export')
        ->middleware('roles');

Route::any('/movimentacoes/relatorio', 'Financial\\TransactionController@report')
        ->name('transaction.report')
        ->middleware('roles');

Route::get('/movimentacoes/transferencia', 'Financial\\TransactionController@createTransfer')
        ->name('transaction.createTransfer')
        ->middleware('roles');

Route::post('/movimentacoes/transferencia', 'Financial\\TransactionController@storeTransfer')
        ->name('transaction.storeTransfer')
        ->middleware('roles');

Route::resource('movimentacoes', 'Financial\\TransactionController')
        ->names('transaction')
        ->parameters(['movimentacoes' => 'transaction'])
        ->middleware('roles');

// ================================ LIBRARIES ===================
// Images
Route::resource('biblioteca-images', 'Libraries\\ImageController')
        ->names('image')
        ->parameters(['biblioteca-images' => 'image'])
        ->middleware('roles');

//texts
Route::put('/textos/apagar/{text}', 'Libraries\\TextController@sendToTrash')
        ->name('text.trash')
        ->middleware('roles');

Route::put('/textos/restaurar/{text}', 'Libraries\\TextController@restoreFromTrash')
        ->name('text.restore')
        ->middleware('roles');

Route::resource('textos', 'Libraries\\TextController')
        ->names('text')
        ->parameters(['textos' => 'text'])
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

// pages
Route::match(['get', 'post'], 'contatos/{page:slug}/cadastrar-contato', 'Sales\\ContactController@storeFromForm')
        ->name('contact.storeForm');

Route::get('/paginas/redirecionar', 'Marketing\\PageController@redirectDomain')
        ->name('contact.domain');

Route::get('/paginas/public/{page:slug}', 'Marketing\\PageController@public')
        ->name('page.public');

Route::get('/paginas/public/redirect/{page}', 'Marketing\\PageController@redirect')
        ->name('page.redirect');

Route::resource('paginas', 'Marketing\\PageController')
        ->names('page')
        ->parameters(['paginas' => 'page'])
        ->middleware('roles');

// ------------------------------------------------ MINHA CONTA ------------------------------------------------
Route::get('/perfil', function () {
    return view('perfil');
});

// ------------------------------------------------ OPERATIONAL  ------------------------------------------------
// // projects
// 

Route::put('/projetos/apagar/{project}', 'Operational\\ProjectController@sendToTrash')
        ->name('project.trash')
        ->middleware('roles');

Route::put('/projetos/restaurar/{project}', 'Operational\\ProjectController@restoreFromTrash')
        ->name('project.restore')
        ->middleware('roles');

Route::get('/projetos/jsonStages/{project}', 'Operational\\ProjectController@jsonStages')
        ->name('project.jsonStages')
        ->middleware('roles');

Route::resource('projetos', 'Operational\\ProjectController')
        ->names('project')
        ->parameters(['projetos' => 'project'])
        ->middleware('roles');

// jornadas
Route::put('jornadas/comecar', 'Operational\\JourneyController@storeFromTask')
        ->name('journey.storeFromTask');

Route::put('/jornadas/encerrar/{journey}', 'Operational\\JourneyController@completeFromTask')
        ->name('journey.completeFromTask');

Route::any('/jornadas/relatorio-funcionarios', 'Operational\\JourneyController@reportByUsers')
        ->name('journey.reportUsers')
        ->middleware('roles');

Route::any('/jornadas/relatorio-departamentos', 'Operational\\JourneyController@reportByDepartments')
        ->name('journey.reportDepartments')
        ->middleware('roles');

Route::put('/jornadas/apagar/{journey}', 'Operational\\JourneyController@sendToTrash')
        ->name('journey.trash')
        ->middleware('roles');

Route::put('/jornadas/restaurar/{journey}', 'Operational\\JourneyController@restoreFromTrash')
        ->name('journey.restore')
        ->middleware('roles');

//Route::put('/jornadas/finalizar/{journey}', 'Operational\\JourneyController@completeJourney')
//        ->name('journey.complete')
//        ->middleware('roles');
//Route::put('/jornadas/finalizar-tarefa/{journey}', 'Operational\\JourneyController@completeJourneyAndTask')
//        ->name('journey.completeTask')
//        ->middleware('roles');

Route::resource('jornadas', 'Operational\\JourneyController')
        ->names('journey')
        ->parameters(['jornadas' => 'journey'])
        ->middleware('roles');

// tasks
Route::get('tarefas/agenda', 'Operational\\TaskController@monthlyCalendar')
        ->name('task.calendar')
        ->middleware('roles');

Route::get('tarefas/pdf/{task}', 'Operational\\TaskController@createPDF')
        ->name('task.pdf')
        ->middleware('roles');

Route::put('/tarefas/apagar/{task}', 'Operational\\TaskController@sendToTrash')
        ->name('task.trash')
        ->middleware('roles');

Route::put('/tarefas/restaurar/{task}', 'Operational\\TaskController@restoreFromTrash')
        ->name('task.restore')
        ->middleware('roles');

Route::put('/tarefas/encerrar/{task}', 'Operational\\TaskController@completeTask')
        ->name('task.complete')
        ->middleware('roles');

Route::get('tarefas/bug', 'Operational\\TaskController@createBug')
        ->name('task.bug')
        ->middleware('roles');

Route::post('tarefas/bug/save', 'Operational\\TaskController@storeBug')
        ->name('task.storeBug')
        ->middleware('roles');

Route::match(['get', 'post'], 'tarefas/novo', 'Operational\\TaskController@create')
        ->name('task.create')
        ->middleware('roles');

Route::resource('tarefas', 'Operational\\TaskController')
        ->except('create')
        ->names('task')
        ->parameters(['tarefas' => 'task'])
        ->middleware('roles');

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
// contato
Route::get('contatos/config-csv', 'Sales\\ContactController@configCsv')
        ->name('contact.config')
        ->middleware('roles');

Route::post('contatos/import-csv', 'Sales\\ContactController@importCsv')
        ->name('contact.import')
        ->middleware('roles');

Route::post('contatos/store-csv', 'Sales\\ContactController@storeCsv')
        ->name('contact.storecsv')
        ->middleware('roles');

Route::get('contatos/publico-alvo', 'Sales\\ContactController@targetAudience')
        ->name('contact.target')
        ->middleware('roles');

Route::resource('contatos', 'Sales\\ContactController')
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
        ->parameters(['modelos-de-contratos' => 'contractTemplate'])
        ->middleware('roles');

// opportunities

Route::get('oportunidades/pdf/relatorio-producao/{opportunity}', 'Sales\\OpportunityController@createProductionPdf')
        ->name('opportunity.pdfProduction')
        ->middleware('roles');
//
//Route::any('/oportunidades/filtros', 'Sales\\OpportunityController@filter')
//        ->name('opportunity.filter')
//        ->middleware('roles');

Route::put('/oportunidades/apagar/{opportunity}', 'Sales\\OpportunityController@sendToTrash')
        ->name('opportunity.trash')
        ->middleware('roles');

Route::put('/oportunidades/restaurar/{opportunity}', 'Sales\\OpportunityController@restoreFromTrash')
        ->name('opportunity.restore')
        ->middleware('roles');

Route::resource('oportunidades', 'Sales\\OpportunityController')
        ->names('opportunity')
        ->parameters(['oportunidades' => 'opportunity'])
        ->middleware('roles');

// products
Route::any('/produtos/filtros', 'Sales\\ProductController@filter')
        ->name('product.filter')
        ->middleware('roles');

Route::put('/produtos/apagar/{product}', 'Sales\\ProductController@sendToTrash')
        ->name('product.trash')
        ->middleware('roles');

Route::put('/produtos/restaurar/{product}', 'Sales\\ProductController@restoreFromTrash')
        ->name('product.restore')
        ->middleware('roles');

Route::get('/produtos/public/{product:name}', 'Sales\\ProductController@public')
        ->name('product.public');

Route::get('/produtos/public/redirect/{product}', 'Sales\\ProductController@redirect')
        ->name('product.redirect');

Route::any('/produtos/relatorio', 'Sales\\ProductController@report')
        ->name('product.report')
        ->middleware('roles');

Route::resource('produtos', 'Sales\\ProductController')
        ->names('product')
        ->parameters(['produtos' => 'product'])
        ->middleware('roles');

// proposals
Route::any('propostas/parcelar/{proposal}', 'Sales\\ProposalController@generateInstallment')
        ->name('proposal.generateInstallment')
        ->middleware('roles');

Route::get('propostas/editar-parcelamento/{proposal}', 'Sales\\ProposalController@editInstallment')
        ->name('proposal.editInstallment')
        ->middleware('roles');

Route::put('propostas/atualizar-parcelamento/{proposal}', 'Sales\\ProposalController@updateInstallment')
        ->name('proposal.updateInstallment')
        ->middleware('roles');

Route::get('propostas/pdf/{proposal}', 'Sales\\ProposalController@createPdf')
        ->name('proposal.pdf')
        ->middleware('roles');

Route::put('/propostas/apagar/{proposal}', 'Sales\\ProposalController@sendToTrash')
        ->name('proposal.trash')
        ->middleware('roles');

Route::put('/propostas/apagar-faturas/{proposal}', 'Sales\\ProposalController@sendToTrashInvoices')
        ->name('proposal.trashInvoices')
        ->middleware('roles');

Route::put('/propostas/restaurar/{proposal}', 'Sales\\ProposalController@restoreFromTrash')
        ->name('proposal.restore')
        ->middleware('roles');

Route::any('/propostas/relatorio', 'Sales\\ProposalController@report')
        ->name('proposal.report')
        ->middleware('roles');

Route::any('/propostas/relatorio/pdf', 'Sales\\ProposalController@createPdfReport')
        ->name('proposal.pdfReport')
        ->middleware('roles');

Route::resource('propostas', 'Sales\\ProposalController')
        ->names('proposal')
        ->parameters(['propostas' => 'proposal'])
        ->middleware('roles');

// shop
Route::resource('loja', 'Sales\\ShopController')
        ->names('shop')
        ->parameters(['loja' => 'shop'])
        ->middleware('roles');

// ------------------------------------------------ SITE  ------------------------------------------------
Route::get('/editarsite', 'SiteCliente@EditarSite')
        ->name('editar-site');

Route::get('/postarsite', 'SiteCliente@PostarSite')
        ->name('postar-site');

