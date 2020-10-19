<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Account;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		$userAuth = Auth::user();

		if (Auth::check()) {
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->get('id');
				
					// filtro de tarefas
			if (!isset($request->status)) {

				$tasks = Task::whereIn('account_id', $accountsID)
						->with(['contact', 'user'])
						->orderBy('date_due', 'DESC')
						->paginate(20, ['*'], 'page');
			} elseif ($request->status == "todos" and $request->contact_id == "todos" and $request->user_id == "todos") {
				$tasks = Task::whereIn('account_id', $accountsID)
//						->filter([
////							'user_id' => $userAuth->id,
//						])
						->with(['contact', 'user'])
						->orderBy('date_due', 'DESC')
						->paginate(3, ['*'], 'page');
			} elseif ($request->status != "todos" and $request->contact_id == "todos" and $request->user_id == "todos") {
				$tasks = Task::whereIn('account_id', $accountsID)
						->filter([
							'status' => $request->status,
						])
						->with(['contact', 'user'])
						->orderBy('date_due', 'DESC')
						->paginate(3, ['*'], 'page');
			} elseif ($request->status == "todos" and $request->contact_id != "todos" and $request->user_id == "todos") {
				$tasks = Task::whereIn('account_id', $accountsID)
						->filter([
							'contact_id' => $request->contact_id,
						])
						->with(['contact', 'user'])
						->orderBy('date_due', 'DESC')
						->paginate(3, ['*'], 'page');
			} elseif ($request->status == "todos" and $request->contact_id == "todos" and $request->user_id != "todos") {
				$tasks = Task::whereIn('account_id', $accountsID)
						->filter([
							'user_id' => $request->user_id_id,
						])
						->with(['contact', 'user'])
						->orderBy('date_due', 'DESC')
						->paginate(3, ['*'], 'page');
			}

			$tasks->appends([
				'status' => $request->status,
				'contact_id' => $request->contact_id,
				'user_id' => $request->user_id,
			]);

			$contacts = Contact::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$users = User::whereHas('accounts', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->orderBy('NAME', 'ASC')
					->get();

			return view('tasks.indexTasks', [
				'tasks' => $tasks,
				'contacts' => $contacts,
				'users' => $users,
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
					->orderBy('NAME', 'ASC')
					->get();

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
		$task = new Task();
		$task->fill($request->all());

		if ($request->end_time == null) {
			$task->duration = 0;
		} else {
			$start_time = strtotime($request->start_time);
			$end_time = strtotime($request->end_time);
			$duration = $end_time - $start_time;
			$task->duration = $duration;
		}
		$task->save();

//		$tempo = gmdate('H:i:s', strtotime( $end_time ) - strtotime( $start_time ) );

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

		if (Auth::check()) {
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
					->orderBy('NAME', 'ASC')
					->get();

			$tasks = Task::whereHas('account', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->with('contact')
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
		} else {
			return redirect('/');
		}
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
		$start_time = strtotime($request->start_time);
		$end_time = strtotime($request->end_time);

		if ($request->end_time == null) {
			$task->duration = 0;
		} else {
			$task->duration = $end_time - $start_time;
		}

		$task->save();


		//	$task->users()->sync($request->users);
////		$timeDifference = Carbon::parse($request->end_time->finish)->diffInMinutes(Carbon::parse($request->start_time->start));
////		$duration->total = $timeDifference / 60; // decimal hours
//
//
////		$duration = $end_time - $start_time;
////		return $diff->format('H:i d/m/Y');
//
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
		$this->$end_time->subHour(1);
		return $this;
	}

	public function filter(Request $request) {
		$userAuth = Auth::user();

		if (Auth::check()) {

			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			if ($request->status == "todos" and $request->contact_id == "todos") {
//				$tasks = Task::whereIn('account_id', $accountsID)
//						->with([
//							'contact',
//							'user'
//						])
//						->where('user_id', $userAuth->id)
//						->orderBy('date_due', 'DESC')
//						->paginate(2);

				$tasks = Task::filter([
							'account_id' => $accountsID,
							'user_id' => $userAuth->id,
						])
						->with(['contact', 'user'])
						->orderBy('date_due', 'DESC')
						->paginate(2, ['*'], 'page');
			} else if ($request->status != "todos" and $request->contact_id == "todos") {
				$tasks = Task::whereIn('account_id', $accountsID)
						->with([
							'contact',
							'user'
						])
						->where('status', $request->status)
						->where('user_id', $userAuth->id)
						->orderBy('date_due', 'DESC')
						->paginate(2);
			} else if ($request->status == "todos" and $request->contact_id != "todos") {
				$tasks = Task::whereIn('account_id', $accountsID)
						->with([
							'contact',
							'user'
						])
						->where('contact_id', $request->contact_id)
						->where('user_id', $userAuth->id)
						->orderBy('date_due', 'DESC')
						->paginate(2);
			} else if ($request->status != "todos" and $request->contact_id != "todos") {
//			$tasks = Task::whereIn('account_id', $accountsID)
//					->with([
//						'contact',
//						'user'
//					])
//					->where('status', $request->status)
//					->where('contact_id', $request->contact_id)
//					->where('user_id', $userAuth->id)
//					->orderBy('date_due', 'DESC')
//					->paginate(2);

				$tasks = Task::filter([
							'status', $request->status,
							'user_id' => $userAuth->id,
							'contact_id', $request->contact_id
						])
						->with(['contact', 'user'])
						->orderBy('date_due', 'DESC')
						->paginate(2, ['*'], 'page');
			}


			$contacts = Contact::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			return view('tasks.indexTasks', [
				'tasks' => $tasks,
				'contacts' => $contacts,
				'userAuth' => $userAuth,
			]);
		} else {
			return redirect('/');
		}
	}

	public function all() {
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
					->orderBy('date_due', 'DESC')
					->paginate(20);

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

}
