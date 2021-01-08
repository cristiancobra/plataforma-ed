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
use DB;

class TaskController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		$today = date('Y-m-d');
		$accountsId = userAccounts();

		$tasks = Task::where(function ($query) use ($accountsId, $request) {
					$query->whereIn('account_id', $accountsId);
					if ($request->name) {
						$query->where('name', 'like', "%$request->name%");
					}
					if ($request->user_id) {
						$query->where('user_id', '=', $request->user_id);
					}
					if ($request->contact_id) {
						$query->where('contact_id', '=', $request->contact_id);
					}
					if ($request->status) {
						$query->where('status', '=', $request->status);
					}
				})
				->with('opportunity', 'journeys')
				->orderByRaw(DB::raw("FIELD(status, 'fazer', 'aguardar', 'feito', 'cancelado', 'fazendo')"))
				->orderByRaw(DB::raw("FIELD(priority, 'emergência', 'alta', 'média', 'baixa')"))
				->orderBy('date_due', 'ASC')
				->paginate(20);

		$tasks->appends([
			'name' => $request->name,
			'status' => $request->status,
			'contact_id' => $request->contact_id,
			'user_id' => $request->user_id,
		]);

		$contacts = Contact::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$accounts = Account::whereIn('id', $accountsId)
				->orderBy('ID', 'ASC')
				->get();

		$users = User::whereHas('accounts', function($query) use($accountsId) {
					$query->whereIn('account_id', $accountsId);
				})
				->orderBy('NAME', 'ASC')
				->get();

		return view('tasks.indexTasks', compact(
						'tasks',
						'contacts',
						'accounts',
						'users',
						'today',
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$task = new Task();

		$accountsId = Account::whereHas('users', function($query) {
					$query->where('users.id', Auth::user()->id);
				})
				->pluck('id');

		$accounts = Account::whereHas('users', function($query) use($accountsId) {
					$query->whereIn('account_id', $accountsId);
				})
				->get();

		$contacts = Contact::whereHas('account', function($query) use($accountsId) {
					$query->whereIn('account_id', $accountsId);
				})
				->orderBy('NAME', 'ASC')
				->get();

		$users = User::whereHas('accounts', function($query) use($accountsId) {
					$query->whereIn('account_id', $accountsId);
				})
				->with('contact')
				->get();

		$today = date("Y-m-d");
		$departments = returnDepartments();
		$status = returnStatus();
		$priorities = returnPriorities();

		return view('tasks.createTask', [
			'users' => $users,
			'task' => $task,
			'accounts' => $accounts,
			'contacts' => $contacts,
			'today' => $today,
			'departments' => $departments,
			'status' => $status,
			'priorities' => $priorities,
		]);
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
		$task->status = 'fazer';

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
		$today = date('Y-m-d');

		return view('tasks.showTask', [
			'today' => $today,
			'task' => $task,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\tasks  $task
	 * @return \Illuminate\Http\Response
	 */
	public function edit(task $task) {
		$accountsID = Account::whereHas('users', function($query) {
					$query->where('users.id', Auth::user()->id);
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

		$departments = returnDepartments();
		$status = returnStatus();
		$priorities = returnPriorities();

		return view('tasks.editTask', [
			'users' => $users,
			'task' => $task,
			'tasks' => $tasks,
			'accounts' => $accounts,
			'contacts' => $contacts,
			'departments' => $departments,
			'status' => $status,
			'priorities' => $priorities,
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
		$today = date('Y-m-d');

		$task->fill($request->all());

		if (isset($request->cancel)) {
			$task->status = 'cancelado';
		} elseif (isset($request->date_conclusion)) {
			$task->status = 'feito';
		} else {
			$task->status = 'fazer';
		}

		$task->save();

		return view('tasks.showTask', [
			'task' => $task,
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
