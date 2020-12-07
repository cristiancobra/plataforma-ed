<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AccountController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) { {
			$userAuth = Auth::user();

			if ($request['role'] === "superadmin") {
				$accounts = Account::where('id', '>', 0)
						->orderBy('NAME', 'asc')
						->paginate(20);
			} elseif ($request['role'] === "administrator") {
				$accounts = Account::whereHas('users', function($query) use($userAuth) {
							$query->where('users.id', $userAuth->id);
						})
						->paginate(20);
			} else {
				return redirect('/painel');
			}

			$totalAccounts = $accounts->count();

			return view('accounts.indexAccounts', [
				'userAuth' => $userAuth,
				'accounts' => $accounts,
				'totalAccounts' => $totalAccounts,
			]);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request) {
		$userAuth = Auth::user();

		$states = returnStates();

		if ($request['role'] === "superadmin") {
			$users = User::where('id', '>', 0)
					->orderBy('NAME', 'asc')
					->get();

			return view('accounts.superadmin_createAccount', [
				'userAuth' => $userAuth,
				'users' => $users,
			]);
		} elseif ($request['role'] === "administrator") {
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$users = User::whereHas('accounts', function($query) use($accountsID) {
						$query->where('accounts.id', $accountsID->first());
					})
					->get();

			return view('accounts.administrator_createAccount', [
				'userAuth' => $userAuth,
				'users' => $users,
			]);
		} else {
			return redirect('/login');
		}

		return view('accounts.createAccount', [
			'userAuth' => $userAuth,
			'users' => $users,
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

		$account = new \App\Models\Account();
		$account->fill($request->all());
		$account->save();
		$account->users()->sync($request->users);

		return redirect()->action('Accounts\\AccountController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Account  $account
	 * @return \Illuminate\Http\Response
	 */
	public function show(Account $account) {
		$userAuth = Auth::user();

		return view('accounts.showAccount', [
			'account' => $account,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Account  $account
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Account $account, Request $request) { {
			$userAuth = Auth::user();

			$usersChecked = User::whereHas('accounts', function($query) use($account) {
						$query->where('account_id', $account->id);
					})
					->pluck('id')
					->toArray();

			$states = returnStates();

			if ($request['role'] === "superadmin") {
				$users = User::where('id', '>', 0)
						->orderBy('NAME', 'asc')
						->get();

				return view('accounts.superadmin_editAccount', [
					'userAuth' => $userAuth,
					'users' => $users,
					'usersChecked' => $usersChecked,
					'account' => $account,
					'states' => $states,
				]);
			} elseif ($request['role'] === "administrator") {
				$accountsID = Account::whereHas('users', function($query) use($userAuth) {
							$query->where('users.id', $userAuth->id);
						})
						->pluck('id');

				$users = User::whereHas('accounts', function($query) use($accountsID) {
							$query->where('accounts.id', $accountsID->first());
						})
						->get();
			} else {
				return redirect('/login');
			}

			$usersChecked = User::whereHas('accounts', function($query) use($account) {
						$query->where('account_id', $account->id);
					})
					->pluck('id')
					->toArray();

			return view('accounts.administrator_editAccount', [
				'userAuth' => $userAuth,
				'users' => $users,
				'usersChecked' => $usersChecked,
				'account' => $account,
				'states' => $states,
			]);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Account  $account
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Account $account) {
		$userAuth = Auth::user();

		$account->fill($request->all());
		$account->save();
		$account->users()->sync($request->users);

		return view('accounts.showAccount', [
			'userAuth' => $userAuth,
			'account' => $account,
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\AccountsModel  $account
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Account $account) {
		$account->delete();
		return redirect()->route('account.index');
	}

}
