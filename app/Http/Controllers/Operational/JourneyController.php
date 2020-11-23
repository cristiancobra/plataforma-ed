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
	public function index() {
		$userAuth = Auth::user();

		if (Auth::check()) {
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->get('id');

			$journeys = Journey::whereIn('account_id', $accountsID)
					->with([
						'account',
						'task',
						'user',
					])
					->paginate(20);
			
			return view('operational.journey.indexJourneys', [
				'journeys' => $journeys,
				'userAuth' => $userAuth,
			]);
		} else {
			return redirect('/');
		}
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
		
		dd($journey->user_id);

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

//			$journey = Journey::where('id', $journey->id)
//					->with('user')
//					->orderBy('DATE', 'DESC')
//					->get();

			$users = User::whereHas('journeys', function($query) use($accountsID) {
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

}
