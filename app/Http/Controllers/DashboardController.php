<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Models\Journey;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

	public function index(Request $request) {
		$userAuth = Auth::user();
		$today = date('Y-m-d');

		$accountsID = Account::whereHas('users', function($query) use($userAuth) {
					$query->where('users.id', $userAuth->id);
				})
				->pluck('id');

		$tasks = Task::whereIn('account_id', $accountsID)
				->get();

		$journeys = Journey::whereIn('account_id', $accountsID)
				->get();

		if ($request['role'] === "superAdmin") {
			$month = returnMonth(date('m'));
			$monthStart = date('Y-m-01');
			$monthEnd = date('Y-m-t');

			$users = User::whereHas('accounts', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->orderBy('NAME', 'ASC')
					->get();

			foreach ($users as $user) {
				$user->hoursMonthly = Journey::where('user_id', $user->id)
						->whereBetween('date', [$monthStart, $monthEnd])
						->sum('duration');
				$user->hoursToday = Journey::where('user_id', $user->id)
						->where('date', $today)
						->sum('duration');
			}

			$todayTotal = Journey::whereIn('account_id', $accountsID)
						->where('date', $today)
						->sum('duration');
			
			$monthTotal = Journey::whereIn('account_id', $accountsID)
						->whereBetween('date', [$monthStart, $monthEnd])
						->sum('duration');

			$tasks_now = $tasks
					->where('status', 'fazendo agora')
					->count();

			$tasks_pending = $tasks
					->whereIn('status', ['fazendo agora', 'pendente'])
					->count();

			$tasks_my = $tasks
					->whereIn('status', ['fazendo agora', 'pendente'])
					->where('user_id', $userAuth->id)
					->count();



			return view('dashboards/superAdministratorDashboard', [
				'userAuth' => $userAuth,
				'month' => $month,
				'users' => $users,
				'today' => $today,
				'tasks_now' => $tasks_now,
				'tasks_pending' => $tasks_pending,
				'tasks_my' => $tasks_my,
				'todayTotal' => $todayTotal,
				'monthTotal' => $monthTotal,
			]);
		}
		if ($request['role'] === "administrator") {
			$month = returnMonth(date('m'));
			$monthStart = date('Y-m-01');
			$monthEnd = date('Y-m-t');

			$users = User::whereHas('accounts', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->orderBy('NAME', 'ASC')
					->get();

			foreach ($users as $user) {
				$user->hoursMonthly = Journey::where('user_id', $user->id)
						->whereBetween('date', [$monthStart, $monthEnd])
						->sum('duration');
				$user->hoursToday = Journey::where('user_id', $user->id)
						->where('date', $today)
						->sum('duration');
			}

			$todayTotal = Journey::whereIn('account_id', $accountsID)
						->where('date', $today)
						->sum('duration');
			
			$monthTotal = Journey::whereIn('account_id', $accountsID)
						->whereBetween('date', [$monthStart, $monthEnd])
						->sum('duration');

			$tasks_now = $tasks
					->where('status', 'fazendo agora')
					->count();

			$tasks_pending = $tasks
					->whereIn('status', ['fazendo agora', 'pendente'])
					->count();

			$tasks_my = $tasks
					->whereIn('status', ['fazendo agora', 'pendente'])
					->where('user_id', $userAuth->id)
					->count();



			return view('dashboards/administratorDashboard', [
				'userAuth' => $userAuth,
				'month' => $month,
				'users' => $users,
				'today' => $today,
				'tasks_now' => $tasks_now,
				'tasks_pending' => $tasks_pending,
				'tasks_my' => $tasks_my,
				'todayTotal' => $todayTotal,
				'monthTotal' => $monthTotal,
			]);
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
					->where('user_id', $userAuth->id)
					->count();

			$hoursTotal = $tasks
					->where('status', 'concluida')
					->where('user_id', $userAuth->id)
					->sum('duration');

			$hoursToday = $tasks
					->where('status', 'concluida')
					->where('user_id', $userAuth->id)
					->where('date_conclusion', $today)
					->sum('duration');

			$hoursAugust = $tasks
					->where('status', 'concluida')
					->where('user_id', $userAuth->id)
					->whereBetween('date_conclusion', ['2020-08-01', '2020-08-31'])
					->sum('duration');

			$hoursSeptember = $tasks
					->where('status', 'concluida')
					->where('user_id', $userAuth->id)
					->whereBetween('date_conclusion', ['2020-09-01', '2020-09-30'])
					->sum('duration');

			$hoursOctober = $tasks
					->where('status', 'concluida')
					->where('user_id', $userAuth->id)
					->whereBetween('date_conclusion', ['2020-10-01', '2020-10-31'])
					->sum('duration');

			$hoursNovember = $tasks
					->where('status', 'concluida')
					->where('user_id', $userAuth->id)
					->whereBetween('date_conclusion', ['2020-10-01', '2020-10-31'])
					->sum('duration');

			$hoursNovember2 = $journeys
					->where('status', 'concluida')
					->where('user_id', $userAuth->id)
					->whereBetween('date', ['2020-10-01', '2020-10-31'])
					->sum('duration');

			return view('dashboards/employeeDashboard', [
				'userAuth' => $userAuth,
				'today' => $today,
				'tasks_now' => $tasks_now,
				'tasks_pending' => $tasks_pending,
				'tasks_my' => $tasks_my,
				'hoursTotal' => $hoursTotal,
				'hoursToday' => $hoursToday,
				'hoursAugust' => $hoursAugust,
				'hoursSeptember' => $hoursSeptember,
				'hoursOctober' => $hoursOctober,
				'hoursNovember' => $hoursNovember,
				'hoursNovember2' => $hoursNovember2,
			]);
		} else {
			return redirect('/login');
		}
	}

}
