<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use App\Models\Journey;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Account;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;

class JourneyController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		$userAuth = Auth::user();

		$accountsID = Account::whereHas('users', function($query) use($userAuth) {
					$query->where('users.id', $userAuth->id);
				})
				->pluck('id');

		$journeys = Journey::where(function ($query) use ($accountsID, $request) {
					$query->whereIn('account_id', $accountsID);
					if ($request->user_id != null) {
						$query->where('user_id', '=', $request->user_id);
					}
				})
				->with([
					'account',
					'task',
					'user',
				])
				->orderBy('DATE', 'DESC')
				->orderBy('START_TIME', 'DESC')
				->paginate(20);

		$journeys->appends([
			'user_id' => $request->user_id,
		]);

		$users = User::whereHas('accounts', function($query) use($accountsID) {
					$query->whereIn('account_id', $accountsID);
				})
				->orderBy('NAME', 'ASC')
				->get();

		$accounts = Account::whereHas('users', function($query) use($userAuth) {
					$query->where('users.id', $userAuth->id);
				})
				->paginate(20);

		return view('operational.journey.indexJourneys', [
			'journeys' => $journeys,
			'users' => $users,
			'accounts' => $accounts,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$userAuth = Auth::user();

		if (Auth::check()) {
			$journey = new Journey();

			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$accounts = Account::whereIn('id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$tasks = Task::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$users = User::whereHas('accounts', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->orderBy('NAME', 'ASC')
					->get();

			return view('operational.journey.createJourney', [
				'userAuth' => $userAuth,
				'journey' => $journey,
				'users' => $users,
				'accounts' => $accounts,
				'tasks' => $tasks,
			]);
		} else {
			return redirect('/');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$userAuth = Auth::user();

		$journey = new Journey();
		$journey->fill($request->all());

		if ($request->end_time == null) {
			$journey->duration = 0;
		} else {
			$start_time = strtotime($request->start_time);
			$end_time = strtotime($request->end_time);
			$journey->duration = $end_time - $start_time;
		}

		$messages = [
			'required' => '*preenchimento obrigatório.',
		];
		$validator = Validator::make($request->all(), [
					'date' => 'required:journeys',
					'start_time' => 'required:journeys',
						], $messages);

		if ($validator->fails()) {
			return back()
							->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
							->withErrors($validator)
							->withInput();
		} else {
			$journey->save();
		}

		return view('operational.journey.showJourney', [
			'journey' => $journey,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Journey  $journey
	 * @return \Illuminate\Http\Response
	 */
	public function show(Journey $journey) {
		$userAuth = Auth::user();

		return view('operational.journey.showJourney', [
			'journey' => $journey,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Journey  $journey
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Journey $journey) {
		$userAuth = Auth::user();

		if (Auth::check()) {
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$accounts = Account::whereHas('users', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->get();

			$tasks = Task::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$users = User::whereHas('accounts', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->get();

			return view('operational.journey.editJourney', [
				'userAuth' => $userAuth,
				'accounts' => $accounts,
				'journey' => $journey,
				'tasks' => $tasks,
				'users' => $users,
			]);
		} else {
			return redirect('/');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Journey  $journey
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Journey $journey) {
		$userAuth = Auth::user();

		$journey->fill($request->all());

		if ($request->end_time == null) {
			$journey->duration = 0;
		} else {
			$start_time = strtotime($request->start_time);
			$end_time = strtotime($request->end_time);
			$journey->duration = $end_time - $start_time;
		}

		$messages = [
			'required' => '*preenchimento obrigatório.',
		];
		$validator = Validator::make($request->all(), [
					'date' => 'required:journeys',
					'start_time' => 'required:journeys',
						], $messages);

		if ($validator->fails()) {
			return back()
							->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
							->withErrors($validator)
							->withInput();
		} else {
			$journey->save();

			return view('operational.journey.showJourney', [
				'userAuth' => $userAuth,
				'journey' => $journey,
			]);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Journey  $journey
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Journey $journey) {
		$journey->delete();
		return redirect()->action('Operational\\JourneyController@index');
	}

	public function monthlyReport(Request $request) {
		$userAuth = Auth::user();

		if (Auth::check()) {
			$months = returnMonths();
			$accounts = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->get();

			$accountsID = $accounts->pluck('id');

			$users = User::whereHas('accounts', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->orderBy('NAME', 'ASC')
					->get();

			$counterArray = 1;
			foreach ($users as $user) {
				$counterMonth = 1;
				while ($counterMonth <= 12) {
					$resultUsers[$counterArray] = Journey::where('user_id', $user->id)
							->whereBetween('date', ["2020-" . str_pad($counterMonth, 2, "0", STR_PAD_LEFT) . "-01", "2020-" . str_pad($counterMonth, 2, "0", STR_PAD_LEFT) . "-31"])
							->sum('duration');
					$counterMonth++;
					$counterArray++;
				}
			}

			$departments = returnDepartments();

			$counterArray = 1;
			foreach ($departments as $department) {
				$counterMonth = 1;
				while ($counterMonth <= 12) {
					$resultCategories[$counterArray] = Journey::whereHas('task', function($query) use($department, $accountsID) {
								$query->whereIn('account_id', $accountsID);
								$query->where('department', 'LIKE', $department);
							})
							->whereBetween('date', ["2020-" . str_pad($counterMonth, 2, "0", STR_PAD_LEFT) . "-01", "2020-" . str_pad($counterMonth, 2, "0", STR_PAD_LEFT) . "-31"])
							->sum('duration');
					$counterMonth++;
					$counterArray++;
				}
			}

			return view('operational.journey.reportsJourneys', [
				'users' => $users,
				'accounts' => $accounts,
				'accountsID' => $accountsID,
				'months' => $months,
				'departments' => $departments,
				'counterMonth' => $counterMonth,
				'counterArray' => $counterArray,
				'resultUsers' => $resultUsers,
				'resultCategories' => $resultCategories,
				'userAuth' => $userAuth,
			]);
		} else {
			return redirect('/');
		}
	}

}
