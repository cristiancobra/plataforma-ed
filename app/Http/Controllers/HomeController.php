<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Lead;
use App\Task;
use App\Opportunities;
use DB;

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

		$myTasks = Task::where('assigned_user_id', $user_crm)
				->get();
		$openTasks = $myTasks
				->where('status', '=', 'Not Started')
				->count();

		$myLeads = Lead::where('assigned_user_id', $user_crm)
				->get();
		$openLeads = $myLeads
				->where('converted', '=', '0')
				->count();

		$myOpportunities = Opportunities::where('assigned_user_id', $user_crm)
				->get();
		$totalOpportunities = $myOpportunities
				->where('sales_stage', '=', 'Prospecting')
				->sum('amount');


//**		MÉTODO ANTIGO
//		$tarefas_abertas = Task::where([
//					['status', 'Not Started'],
//					['assigned_user_id', $user_crm]
//				])
//				->get();


		if ($user->perfil == "administrador") {

			return view('admin/painel-admin', [
				'user' => $user,
				'openTasks' => $openTasks,
				'openLeads' => $openLeads,
				'totalOpportunities' => $totalOpportunities,
			]);
		} else {
			return view('painel', [
				'user' => $user,
				'openTasks' => $openTasks,
				'openLeads' => $openLeads,
				'totalOpportunities' => $totalOpportunities,
			]);
		}
	}

	public function ContarTarefas() {

		$total_tarefas = count($tarefas_abertas)->get();
		return $total_tarefas;
	}

}
