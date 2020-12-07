<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Models\Journey;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

	/**
	 * Display a listing of the resource
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		$userAuth = Auth::user();

		$accounts = Account::whereHas('users', function($query) use($userAuth) {
					$query->where('users.id', $userAuth->id);
				})
				->get();

		if ($request['role'] === "superadmin") {
			$users = User::where('id', '>', 0)
					->orderBy('NAME', 'asc')
					->paginate(20);
			
		} elseif ($request['role'] === "administrator") {
			$users = User::whereHas('accounts', function($query) use($accounts) {
						$query->where('accounts.id', $accounts->first()->id);
					})
					->paginate(20);
		} else {
			return redirect('/login');
		}

		$totalUsers = $users->count();

		return view('users.indexUsers', [
			'users' => $users,
			'accounts' => $accounts,
			'userAuth' => $userAuth,
			'totalUsers' => $totalUsers,
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request) {
		$user = new User();
		$userAuth = Auth::user();

		if ($request['role'] === "superadmin") {
			$accounts = Account::where('id', '>', 0)
					->orderBy('NAME', 'asc')
					->paginate(20);

			return view('users.superadmin_createUser', [
				'user' => $user,
				'userAuth' => $userAuth,
				'accounts' => $accounts,
			]);
			
		} elseif ($request['role'] === "administrator") {
			
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->get('id');
					
			$accounts = Account::whereIn('id', $accountsID)
					->orderBy('ID', 'ASC')
					->get();

			return view('users.administrator_createUser', [
				'user' => $user,
				'userAuth' => $userAuth,
				'accounts' => $accounts,
			]);
		} else {
			return redirect('/login');
		}


		return view('users.superadmin_createUser', [
			'user' => $user,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$userAuth = Auth::user();

		$user = new User();
		$user->name = ucfirst($request->novo_nome) . " " . ucfirst($request->novo_sobrenome);
		$user->perfil = $request->perfil;
		$user->email = $request->email;
		$user->default_password = $request->password;
		$user->password = \Illuminate\Support\Facades\Hash::make($request->password);
		$user->save();
		
		$user->accounts()->sync($request->accounts);

		return view('users.showUser', [
			'user' => $user,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function show(User $user) {
		$userAuth = Auth::user();

		return view('users.showUser', [
			'user' => $user,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function edit(User $user, Request $request) {
		$userAuth = Auth::user();

		$accounts = Account::whereHas('users', function($query) use($userAuth) {
					$query->where('users.id', $userAuth->id);
				})
				->get();
				
		if ($request['role'] === "superadmin") {
			$accounts = Account::where('id', '>', 0)
					->orderBy('NAME', 'asc')
					->paginate(20);

			return view('users.superadmin_editUser', [
				'user' => $user,
				'userAuth' => $userAuth,
				'accounts' => $accounts,
			]);
			
		} elseif ($request['role'] === "administrator") {
			
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->get('id');
					
			$accounts = Account::whereIn('id', $accountsID)
					->orderBy('ID', 'ASC')
					->get();


			return view('users.administrator_editUser', [
			'user' => $user,
			'userAuth' => $userAuth,
			'accounts' => $accounts,
		]);
	}
}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, User $user) {
		$user->fill($request->all());
		$user->accounts()->sync($request->accounts);

		if (!empty($request->password)) {
			$user->password = \Illuminate\Support\Facades\Hash::make($request->password);
		}

		return redirect()->route('user.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user) {
		$user->delete();
		return redirect()->route('user.index');
	}

	public function dashboardUser() {
		$userAuth = Auth::user();
		$today = date('Y-m-d');

		if (Auth::check()) {

			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$tasks = Task::whereIn('account_id', $accountsID)
					->get();

			$journeys = Journey::whereIn('account_id', $accountsID)
					->get();

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

			return view('users/dashboardUser', [
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
			return redirect('/');
		}
	}

	public function dashboardAdministrator() {
		$userAuth = Auth::user();
		$today = date('Y-m-d');

		if (Auth::check()) {

			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$tasks = Task::whereIn('account_id', $accountsID)
					->get();

			$journeys = Journey::whereIn('account_id', $accountsID)
					->get();

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

			return view('users/dashboardAdministrator', [
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
			return redirect('/');
		}
	}

//	public function filterUsers(Request $request) {
}
