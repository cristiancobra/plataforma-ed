<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Journey;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use DB;

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

			$tasks = Task::where(function ($query) use ($accountsID, $request) {
						$query->whereIn('account_id', $accountsID);
						if ($request->name == null && $request->user_id == null && $request->contact_id == null && $request->status == null) {
							$query->where('status', '!=', 'concluida')
							->where('status', '!=', 'cancelada');
						} else {
							if ($request->name != null) {
								$query->where('name', 'like', "%$request->name%");
							}
							if ($request->user_id != null) {
								$query->where('user_id', '=', $request->user_id);
							}
							if ($request->contact_id != null) {
								$query->where('contact_id', '=', $request->contact_id);
							}
							if ($request->status != null) {
								$query->where('status', '=', $request->status);
							}
						}
					})
					->with('journeys')
					->orderByRaw(DB::raw("FIELD(status, 'fazendo agora', 'pendente')"))
					->orderByRaw(DB::raw("FIELD(priority, 'emergência', 'alta', 'média', 'baixa')"))
					->orderBy('date_due', 'ASC')
					->paginate(20);
//dd($tasks);
			$tasks->appends([
				'name' => $request->name,
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

//			$totalDuration = Journey::whereHas('accounts', function($query) use($accountsID) {
//						$query->whereIn('account_id', $accountsID);
//					})
//					->orderBy('NAME', 'ASC')
//					->get();

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
		$userAuth = Auth::user();

		$task = new Task();
		$task->fill($request->all());

//		if ($request->end_time == null) {
//			$task->duration = 0;
//		} else {
//			$start_time = strtotime($request->start_time);
//			$end_time = strtotime($request->end_time);
//			$duration = $end_time - $start_time;
//			$task->duration = $duration;
//		}

		$messages = [
			'required' => '*preenchimento obrigatório.',
		];
		$validator = Validator::make($request->all(), [
					'name' => 'required:tasks',
					'date_start' => 'required:tasks',
					'date_due' => 'required:tasks',
					'description' => 'required:tasks',
						],
						$messages);

		if ($validator->fails()) {
			return back()
							->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
							->withErrors($validator)
							->withInput();
		} else {
			$task->save();

			$journeys = Journey::where('task_id', $task->id)->get();

			return view('tasks.showTask', [
				'task' => $task,
				'journeys' => $journeys,
				'userAuth' => $userAuth,
			]);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\tasks  $task
	 * @return \Illuminate\Http\Response
	 */
	public function show(task $task) {
		$userAuth = Auth::user();

		$journeys = Journey::where('task_id', $task->id)
				->with('user')
				->get();

		return view('tasks.showTask', [
			'task' => $task,
			'journeys' => $journeys,
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

		$journeys = Journey::where('task_id', $task->id)->get();

		return view('tasks.showTask', [
			'task' => $task,
			'journeys' => $journeys,
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

}
