<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Task;
use App\UserCrm;

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
        $user_crm = Auth::user()->idcrm;
              $tarefas_abertas = Task::where([
                  ['status','Not Started'],
                  ['assigned_user_id',$user_crm]
                      ])
                  ->get();
            
              $total_tarefas = count($tarefas_abertas);
              
                if ($user->perfil == "administrador") {
                    
            return view('admin/painel-admin', [
             'user' => $user,
             'tarefas_abertas' => $tarefas_abertas,
                'total_tarefas' => $total_tarefas,
            ]);
        } else {
        return view('painel', [
            'user' => $user
        ]);
    }
    }
        public function ContarTarefas() {
                   
            $total_tarefas = count($tarefas_abertas)->get();
            return $total_tarefas;
        }
}