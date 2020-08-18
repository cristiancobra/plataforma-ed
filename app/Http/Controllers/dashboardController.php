<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Lead;
use App\Task;
use App\Opportunities;

class dashboardController extends Controller {

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
		$userAuth = Auth::user();
		$hoje = date("d/m/Y");
		$user_crm = Auth::user()->idcrm;

		$totalTasks = Task::where([
					['assigned_user_id', $user_crm],
					['deleted', '=', '0']
				])
				->Where(function($consultaStatus) {
					$consultaStatus->orwhere('status', '=', 'Not Started')
					->orwhere('status', '=', 'In Progress');
				})
				->count();

		$totalLeads = Lead::where([
					['assigned_user_id', $user_crm],
					['deleted', '=', '0']
				])
				->Where(function($consultaStatus) {
					$consultaStatus->orwhere('status', '=', 'New')
					->orwhere('status', '=', 'Assigned')
					->orwhere('status', '=', 'In Process')
					->orwhere('status', '=', 'Recycled');
				})
				->count();

		$totalOpportunities = Opportunities::where([
					['assigned_user_id', $user_crm],
					['deleted', '=', '0'],
					['sales_stage', '!=', 'Closed Lost'],
					['sales_stage', '!=', 'Closed Won']
				])
				->sum('amount');

		return view('usuarios/dashboardUser', [
			'userAuth' => $userAuth,
			'hoje' => $hoje,
			'totalTasks' => $totalTasks,
			'totalLeads' => $totalLeads,
			'totalOpportunities' => $totalOpportunities,
		]);
	}

	public function ContarTarefas() {

		$total_tarefas = count($tarefas_abertas)->get();
		return $total_tarefas;
	}

}
