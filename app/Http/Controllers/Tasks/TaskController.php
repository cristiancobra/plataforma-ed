<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$userAuth = Auth::user();
		if ($userAuth->perfil == "administrador") {
			$tasks = Task::where('id', '>=', 0)
					->with('users')
					->orderBy('ID', 'asc')
					->get();
		} else {
			$tasks = Task::where('user_id', '=', $userAuth->id)
					->with('users')
					->get();
		}

		return view('tasks.indexTasks', [
			'tasks' => $tasks,
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
		if ($userAuth->perfil == "administrador") {
			$users = User::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();
		} else {
			$users = User::where('id', '=', $userAuth->id)->with('accounts')->get();
		}

		$task = new Task();

		$accounts = Task::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();

		return view('tasks.createTask', [
			'userAuth' => $userAuth,
			'users' => $users,
			'task' => $task,
			'accounts' => $accounts,
		]);
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
		if ($userAuth->perfil == "administrador") {
			$users = User::where('id', '>=', 0)
					->orderBy('NAME', 'asc')
					->get();
		} else {
			$users = User::where('id', '=', $userAuth->id)
					->with('accounts')
					->get();
		}

		return view('tasks.editTask', [
			'userAuth' => $userAuth,
			'users' => $users,
			'task' => $task,
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

		return view('tasks.showTask', [
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

}
