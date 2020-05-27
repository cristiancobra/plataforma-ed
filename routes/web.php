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

// Route::get('/', function () {
//     return view('painel');
// });



// Route::get('/list', 'LoginTesteController@ListUser')->name('list');

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

Route::get('/financeiro', function () {
    return view('financeiro');
});

Route::get('/nuvem', function () {
    return Redirect::to('https://nuvem.empresadigital.net.br');
});

Route::get('/falar', function () {
    return Redirect::to('https://nuvem.empresadigital.net.br/index.php/apps/spreed/');
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