<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class LoginTesteController extends Controller {

    public function ListUser() {
        $user = User::where('user_name', 'cristiancobra')->first();
        return view('painel', [
        'userList' => $user
        ]);
    }
  
        public function IsAdmin() {
        $status = User::where('user_name', 'cristiancobra')->first();
        if ($status->is_admin = 1);
        echo "voce é admin";
    }

    }
    