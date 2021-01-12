<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Models\Journey;
use App\Models\Task;
use App\Models\Opportunity;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

	public function index(Request $request) {
		$accountsId = userAccounts();

		$tasks = Task::whereIn('account_id', $accountsId)
				->get();

		$opportunities = Opportunity::whereIn('account_id', $accountsId)
				->get();

		$journeys = Journey::whereIn('account_id', $accountsId)
				->get();

//		if ($request['role'] === "superadmin") {
//			$month = returnMonth(date('m'));
//			$monthStart = date('Y-m-01');
//			$monthEnd = date('Y-m-t');
//
//			$users = User::whereHas('accounts', function($query) use($accountsID) {
//						$query->whereIn('account_id', $accountsID);
//					})
//					->orderBy('NAME', 'ASC')
//					->get();
//
//			foreach ($users as $user) {
//				$user->hoursMonthly = Journey::where('user_id', $user->id)
//						->whereBetween('date', [$monthStart, $monthEnd])
//						->sum('duration');
//				$user->hoursToday = Journey::where('user_id', $user->id)
//						->where('date', $today)
//						->sum('duration');
//			}
//
//			$todayTotal = Journey::whereIn('account_id', $accountsID)
//					->where('date', $today)
//					->sum('duration');
//
//			$monthTotal = Journey::whereIn('account_id', $accountsID)
//					->whereBetween('date', [$monthStart, $monthEnd])
//					->sum('duration');
//
//			$tasks_now = $tasks
//					->where('status', 'fazendo')
//					->count();
//
//			$tasks_pending = $tasks
//					->whereIn('status', ['fazendo', 'fazer'])
//					->count();
//
//			$tasks_my = $tasks
//					->whereIn('status', ['fazendo', 'fazer'])
//					->where('user_id', $userAuth->id)
//					->count();
//
//			$opportunities_now = $opportunities
//					->where('status', 'fazendo')
//					->count();
//
//			$opportunities_pending = $opportunities
//					->whereIn('status', ['fazendo', 'fazer'])
//					->count();
//
//			$opportunities_my = $opportunities
//					->whereIn('status', ['fazendo', 'fazer'])
//					->where('user_id', $userAuth->id)
//					->count();
//
//			return view('dashboards/superadmin_dashboard', [
//				'userAuth' => $userAuth,
//				'month' => $month,
//				'users' => $users,
//				'today' => $today,
//				'tasks_now' => $tasks_now,
//				'tasks_pending' => $tasks_pending,
//				'tasks_my' => $tasks_my,
//				'opportunities_now' => $opportunities_now,
//				'opportunities_pending' => $opportunities_pending,
//				'opportunities_my' => $opportunities_my,
//				'todayTotal' => $todayTotal,
//				'monthTotal' => $monthTotal,
//			]);
//		}
		if ($request['role'] === "administrator" OR $request['role'] === "superadmin") {
			$month = returnMonth(date('m'));
			$monthStart = date('Y-m-01');
			$monthEnd = date('Y-m-t');

			$users = User::whereHas('accounts', function($query) use($accountsId) {
						$query->whereIn('account_id', $accountsId);
					})
					->orderBy('NAME', 'ASC')
					->get();

			foreach ($users as $user) {
				$user->hoursMonthly = Journey::where('user_id', $user->id)
						->whereBetween('date', [$monthStart, $monthEnd])
						->sum('duration');
				$user->hoursToday = Journey::where('user_id', $user->id)
						->where('date',  date('Y-m-d'))
						->sum('duration');
			}

			$todayTotal = Journey::whereIn('account_id', $accountsId)
					->where('date',  date('Y-m-d'))
					->sum('duration');

			$monthTotal = Journey::whereIn('account_id', $accountsId)
					->whereBetween('date', [$monthStart, $monthEnd])
					->sum('duration');

			$tasks_now = $tasks
					->where('status', 'fazendo')
					->count();

			$tasks_pending = $tasks
					->whereIn('status', ['fazendo', 'fazer'])
					->count();

			$tasks_my = $tasks
					->whereIn('status', ['fazendo', 'fazer'])
					->where('user_id',  Auth::user()->id)
					->count();

			$opportunitiesProspecting = $opportunities
					->where('stage', 'prospecção')
					->count();

			$opportunitiesPresentation = $opportunities
					->where('stage', 'apresentação')
					->count();

			$opportunitiesProposal = $opportunities
					->where('stage', 'proposta')
					->where('user_id',  Auth::user()->id)
					->count();

			$opportunitiesWon = $opportunities
					->where('stage', 'ganhamos')
					->where('user_id',  Auth::user()->id)
					->count();

			$opportunitiesLost = $opportunities
					->where('stage', 'perdemos')
					->where('user_id',  Auth::user()->id)
					->count();

			return view('dashboards/administratorDashboard', compact(
				'month',
				'users',
				'tasks_now',
				'tasks_pending',
				'tasks_my',
				'opportunitiesProspecting',
				'opportunitiesPresentation',
				'opportunitiesProposal',
				'opportunitiesWon',
				'opportunitiesLost',
				'todayTotal',
				'monthTotal',
			));
		}
		if ($request['role'] === "employee") {
			$tasks_now = $tasks
					->where('status', 'fazendo agora')
					->count();

			$tasks_pending = $tasks
					->whereIn('status', ['fazendo agora', 'pendente'])
					->count();

			$tasks_my = $tasks
					->whereIn('status', ['fazendo agora', 'pendente'])
					->where('user_id', Auth::user()->id)
					->count();

			$hoursTotal = $tasks
					->where('status', 'concluida')
					->where('user_id', Auth::user()->id)
					->sum('duration');

			$hoursToday = $tasks
					->where('status', 'concluida')
					->where('user_id', Auth::user()->id)
					->where('date_conclusion', $today)
					->sum('duration');

			$hoursAugust = $tasks
					->where('status', 'concluida')
					->where('user_id', Auth::user()->id)
					->whereBetween('date_conclusion', ['2020-08-01', '2020-08-31'])
					->sum('duration');

			$hoursSeptember = $tasks
					->where('status', 'concluida')
					->where('user_id', Auth::user()->id)
					->whereBetween('date_conclusion', ['2020-09-01', '2020-09-30'])
					->sum('duration');

			$hoursOctober = $tasks
					->where('status', 'concluida')
					->where('user_id', Auth::user()->id)
					->whereBetween('date_conclusion', ['2020-10-01', '2020-10-31'])
					->sum('duration');

			$hoursNovember = $tasks
					->where('status', 'concluida')
					->where('user_id', Auth::user()->id)
					->whereBetween('date_conclusion', ['2020-10-01', '2020-10-31'])
					->sum('duration');

			$hoursNovember2 = $journeys
					->where('status', 'concluida')
					->where('user_id', Auth::user()->id)
					->whereBetween('date', ['2020-10-01', '2020-10-31'])
					->sum('duration');

			return view('dashboards/employeeDashboard', compact(
				'today',
				'tasks_now',
				'tasks_pending',
				'tasks_my',
				'hoursTotal',
				'hoursToday',
				'hoursAugust',
				'hoursSeptember',
				'hoursOctober',
				'hoursNovember',
				'hoursNovember2',
			));
		} else {
			return redirect('/login');
		}
	}

}
