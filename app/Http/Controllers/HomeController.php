<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $user = Auth::user();
        if ($user->perfil == "administrador") {
            return view('admin/painel-admin', [
                'user' => $user
            ]);
        } else {
        return view('painel', [
            'user' => $user
        ]);
    }

}
}