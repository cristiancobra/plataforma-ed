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
        if ($user->is_admin == 0) {
            return view('painel', [
                'user' => $user
            ]);
        } else {
        return view('admin/painel-admin', [
            'user' => $user
        ]);
    }

}
}