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


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/logout', function () {
    Auth::logout();
    return Redirect::to('/');
});

// ----------------------  Rotas do MENU ---------

Route::get('/crm', function () {
    return view('crm');
});

Route::get('/oportunidades', function () {
    return view('oportunidades');
});

Route::get('/senhas', function () {
    return view('senhas');
});

Route::get('/financeiro', function () {
    return view('financeiro');
});

Route::get('/gerenciador-financeiro', function () {
    return view('gerenciador-financeiro');
});

Route::get('/nuvem', function () {
    return Redirect::to('https://nuvem.empresadigital.net.br');
});

Route::get('/falar', function () {
    return view('falar');
});

Route::get('/campanhas', function () {
    return view('campanhas');
});

Route::get('/email', function () {
    return view('email');
});

Route::get('/suporte', function () {
   return view('suporte');
});

Route::get('/teste', function () {
    return view('teste');
    });
    
    Route::get('/inicio', function () {
    return view('inicio');
    });
    
    Route::get('/arquivosdemkt', function () {
    return view('arquivosdemkt');
});
Route::get('/banco', function () {
    return view('banco');
});

Route::get('/editarsite', 'SiteCliente@EditarSite')->name('editar-site');
Route::get('/postarsite', 'SiteCliente@PostarSite')->name('postar-site');


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
Route::get('/novopotencial', function () {
    return view('novopotencial');
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
    
    Route::get('/instalar-plataforma', function () {
    return view('admin.instalar-plataforma');
});