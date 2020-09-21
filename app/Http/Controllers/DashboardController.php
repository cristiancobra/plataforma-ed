<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Lead;
use App\Models\Task;
use App\Opportunities;

class DashboardController extends Controller {

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
	public function home() {
		$userAuth = Auth::user();
		$hoje = date("d/m/Y");

		if (Auth::check()) {
			$tasks = Task::where('user_id', '=', $userAuth->id)
					->where('status', '=', "pendente")
					->orwhere('status', '=', "em andamento")
					->count();

			return view('usuarios/dashboardUser', [
				'userAuth' => $userAuth,
				'hoje' => $hoje,
				'tasks' => $tasks,
			]);
		} else {
			return redirect('/');
		}
	}

	public function ContarTarefas() {

		$total_tarefas = count($tarefas_abertas)->get();
		return $total_tarefas;
	}

}
