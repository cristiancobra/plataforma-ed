<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use App\Models\Journey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\Task;
use App\Models\Account;
use App\Models\Contact;
use App\Models\User;

class JourneyController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		$journeys = Journey::where(function ($query) use ($request) {
					$query->whereIn('account_id', userAccounts());
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

		$users = myUsers();

		$accounts = Account::whereHas('users', function($query) {
					$query->where('users.id', Auth::user()->id);
				})
				->paginate(20);

		return view('operational.journey.indexJourneys', compact(
						'journeys',
						'users',
						'accounts',
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$accounts = Account::whereHas('users', function($query) {
					$query->whereIn('account_id', userAccounts());
				})
				->get();
                                
		$tasks = Task::whereIn('account_id', userAccounts())
				->orderBy('NAME', 'ASC')
				->get();

		$users = User::whereHas('accounts', function($query) {
					$query->whereIn('account_id', userAccounts());
				})
				->join('contacts', 'contacts.id', '=', 'users.contact_id')
				->orderBy('NAME', 'ASC')
				->get();

		return view('operational.journey.createJourney', compact(
						'users',
						'accounts',
						'tasks',
		));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$messages = [
			'required' => '*preenchimento obrigatório.',
		];
		$validator = Validator::make($request->all(), [
					'date' => 'required:journeys',
					'start_time' => 'required:journeys',
					'user_id' => 'required:tasks',
						], $messages);

		if ($validator->fails()) {
			return back()
							->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
							->withErrors($validator)
							->withInput();
		} else {

			$journey = new Journey();
			$journey->fill($request->all());

			if ($request->end_time == null) {
				$journey->duration = 0;
			} else {
				$start_time = strtotime($request->start_time);
				$end_time = strtotime($request->end_time);
				$journey->duration = $end_time - $start_time;
			}
			$journey->save();
		}

		return view('operational.journey.showJourney', compact(
						'journey',
		));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Journey  $journey
	 * @return \Illuminate\Http\Response
	 */
	public function show(Journey $journey) {
		
		return view('operational.journey.showJourney', compact(
						'journey',
		));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Journey  $journey
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Journey $journey) {
		$accounts = Account::whereHas('users', function($query) {
					$query->whereIn('account_id', userAccounts());
				})
				->get();

			$tasks = Task::whereIn('account_id', userAccounts())
					->orderBy('NAME', 'ASC')
					->get();

			$users = User::whereHas('accounts', function($query) {
						$query->whereIn('account_id', userAccounts());
					})
					->get();

			return view('operational.journey.editJourney', compact(
				'accounts',
				'journey',
				'tasks',
				'users',
			));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Journey  $journey
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Journey $journey) {
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
		$journey->fill($request->all());

		if ($request->end_time == null) {
			$journey->duration = 0;
		} else {
			$start_time = strtotime($request->start_time);
			$end_time = strtotime($request->end_time);
			$journey->duration = $end_time - $start_time;
		}
			$journey->save();

			return view('operational.journey.showJourney', [
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
		$months = returnMonths();

		if (isset($request->year)) {
			$year = $request->year;
		} else {
			$year = date('y');
		}

		$users = myUsers(['contact']);

		$counterArray = 1;
		foreach ($users as $user) {
			$counterMonth = 1;
			while ($counterMonth <= 12) {
				$initialDate = $year . "-" . str_pad($counterMonth, 2, "0", STR_PAD_LEFT) . "-01";
				$finalDate = $year . "-" . str_pad($counterMonth, 2, "0", STR_PAD_LEFT) . "-31";
				$resultUsers[$counterArray] = Journey::where('user_id', $user->id)
						->whereBetween('date', [$initialDate, $finalDate])
						->sum('duration');
				$resultMonth[$counterArray] = Journey::whereHas('user', function($query) {
					$query->whereIn('account_id', userAccounts());
                                                                                               })
						->whereBetween('date', [$initialDate, $finalDate])
						->sum('duration');
                                
				$counterMonth++;
				$counterArray++;
			}
		}
//dd($resultUsers);
		$departments = returnDepartments();

		$counterArray = 1;
		foreach ($departments as $department) {
			$counterMonth = 1;
			while ($counterMonth <= 12) {
				$initialDate = $year . "-" . str_pad($counterMonth, 2, "0", STR_PAD_LEFT) . "-01";
				$finalDate = $year . "-" . str_pad($counterMonth, 2, "0", STR_PAD_LEFT) . "-31";
				$resultCategories[$counterArray] = Journey::whereHas('task', function($query) use($department) {
							$query->whereIn('account_id', userAccounts());
							$query->where('department', 'LIKE', $department);
						})
						->whereBetween('date', [$initialDate, $finalDate])
						->sum('duration');
				$counterMonth++;
				$counterArray++;
			}
		}

		return view('operational.journey.reportsJourneys', compact(
						'users',
						'months',
						'departments',
						'counterMonth',
						'counterArray',
						'resultUsers',
						'resultMonth',
						'resultCategories',
		));
	}

}
