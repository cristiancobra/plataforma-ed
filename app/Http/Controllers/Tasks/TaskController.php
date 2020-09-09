<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Account;
use App\Models\Contact;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskController extends Controller {

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
					->pluck('id');

			$tasks = Task::whereHas('account', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID)
						->with('contact');
					})
					->orderByRaw('FIELD(status, "pendente", "fazendo agora") desc')
					->paginate(20);
//			dd($tasks);

			$hoje = date("d/m/Y");

			return view('tasks.indexTasks', [
				'hoje' => $hoje,
				'tasks' => $tasks,
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
			$task = new Task();

			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$accounts = Account::whereHas('users', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->get();

			$contacts = Contact::whereHas('account', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->paginate(20);

//		dd($contacts);

			$users = User::whereHas('accounts', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->get();

			return view('tasks.createTask', [
				'userAuth' => $userAuth,
				'users' => $users,
				'task' => $task,
				'accounts' => $accounts,
				'contacts' => $contacts,
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
		Task::create($request->all());

		return redirect()->action('Tasks\\TaskController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\tasks  $task
	 * @return \Illuminate\Http\Response
	 */
	public function show(task $task) {
		$userAuth = Auth::user();

		return view('tasks.showTask', [
			'task' => $task,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\tasks  $task
	 * @return \Illuminate\Http\Response
	 */
	public function edit(task $task) {
		$userAuth = Auth::user();

		$accountsID = Account::whereHas('users', function($query) use($userAuth) {
					$query->where('users.id', $userAuth->id);
				})
				->pluck('id');

		$accounts = Account::whereHas('users', function($query) use($accountsID) {
					$query->whereIn('account_id', $accountsID);
				})
				->get();

		$contacts = Contact::whereHas('account', function($query) use($accountsID) {
					$query->whereIn('account_id', $accountsID);
				})
				->paginate(20);

		$tasks = Task::whereHas('account', function($query) use($accountsID) {
					$query->whereIn('account_id', $accountsID);
				})
				->paginate(20);

		$users = User::whereHas('accounts', function($query) use($accountsID) {
					$query->whereIn('account_id', $accountsID);
				})
				->get();

		return view('tasks.editTask', [
			'userAuth' => $userAuth,
			'users' => $users,
			'task' => $task,
			'tasks' => $tasks,
			'accounts' => $accounts,
			'contacts' => $contacts,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\tasks  $task
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, task $task) {
		$userAuth = Auth::user();

		$task->fill($request->all());
		$task->save();
		//	$task->users()->sync($request->users);
////		$timeDifference = Carbon::parse($request->end_time->finish)->diffInMinutes(Carbon::parse($request->start_time->start));
////		$duration->total = $timeDifference / 60; // decimal hours
//
//		$start_time = strtotime($request->start_time);
//		$end_time = strtotime($request->end_time);
//		$duration = $end_time - $start_time;
//
////		$duration = $end_time - $start_time;
////		return $diff->format('H:i d/m/Y');
////
//		$task->fill($request->all());
//		$task->duration = date("H:i", $duration);
//		$task->save();
//		$hours = $task->duration  / 3600; // decimal hours;

		return view('tasks.showTask', [
//			'hours' => $hours,
			'task' => $task,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\tasks  $task
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(task $task) {
		$task->delete();
		return redirect()->action('Tasks\\TaskController@index');
	}

	public function duration(start_time $start_time, end_time $end_time) {
		$duration = $end_time - $start_time;
		return $duration;
	}

}
