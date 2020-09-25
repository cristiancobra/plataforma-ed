<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Lead;
use App\Models\Account;
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
			
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$tasks_now = Task::whereHas('account', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->where('status', 'fazendo agora')
					->count();

			$tasks_pending = Task::whereHas('account', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->whereIn('status', ['fazendo agora', 'pendente'])
					->count();

			$tasks_my = Task::whereHas('account', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->whereIn('status', ['fazendo agora', 'pendente'])
					->where('user_id', $userAuth->id)
					->count();


			return view('usuarios/dashboardUser', [
				'userAuth' => $userAuth,
				'hoje' => $hoje,
				'tasks_now' => $tasks_now,
				'tasks_pending' => $tasks_pending,
				'tasks_my' => $tasks_my,
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
