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
	public function index() {
		    {
		$userAuth = Auth::user();

		if (Auth::check()) {
			
		if ($userAuth->perfil == "administrador") {
			$accounts = Account::where('id', '>=', 0)
					->orderBy('NAME', 'asc')
					->paginate(20);
		} else {
			$accounts = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->paginate(20);
		}
		
		$totalAccounts= $accounts->count();

		return view('accounts.indexAccounts', [
			'userAuth' => $userAuth,
			'accounts' => $accounts,
			'totalAccounts' => $totalAccounts,
			]);
		} else {
			return redirect('/');
		}
	}
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$userAuth = Auth::user();
		$account = new Account();
		if ($userAuth->perfil == "administrador") {
			$users = User::where('id', '>=', 0)
					->orderBy('NAME', 'asc')
					->get();
		} else {
			
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$users = User::whereIn('id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();
		}

		$accounts = \App\Models\Account::where('id', '>=', 0)
				->orderBy('NAME', 'asc')
				->get();

		return view('accounts.createAccount', [
			'userAuth' => $userAuth,
			'users' => $users,
			'account' => $account,
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
	public function edit(Account $account) {
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

		$idsAccount = Account::find($account->id)
				->with('users')
				->orderBy('NAME', 'asc')
				->get();

		return view('accounts.editAccount', [
			'userAuth' => $userAuth,
			'users' => $users,
			'account' => $account,
			'idsAccount' => $idsAccount,
		]);
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
