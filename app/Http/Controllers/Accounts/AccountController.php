<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\AccountModel;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$accounts = AccountModel::all();
	//	$emails = User::emails();
		$user = Auth::user();

		return view('accounts.listAllAccounts', [
			'accounts' => $accounts,
			'user' => $user,
		]);
	}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$account = new \App\Models\AccountModel();
		$user = Auth::user();
		//$users = User::all()->with(accounts);
		//$accounts = $users->accounts()->get();
		
		return view('accounts.createAccount', [
			'user' => $user,
//			'users' => $users,
			'account' => $account,
//			'accounts' => $accounts,
		]);
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$account = new \App\Models\AccountModel();
		$account->name = ($request->name);
		$account->email = ($request->email);
		$account->phone = ($request->phone);
		$account->site = ($request->site);
		$account->address = ($request->address);
		$account->address_city = ($request->address_city);
		$account->address_state = ($request->address_state);
		$account->address_country = ($request->address_country);
		$account->type = ($request->type);
		$account->employees = ($request->employees);
		$account->save();
		

		$accounts = \App\Models\AccountModel::all();
		$user = Auth::user();

		return view('accounts.listAllAccounts', [
			'user' => $user,
			'accounts' => $accounts,
		]);
	}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccountsModel  $accountsModel
     * @return \Illuminate\Http\Response
     */
    public function show(AccountModel $accountModel)
    {
		$user = Auth::user();
		return view('accounts.detailsAccount', [
			'account' => $accountModel,
			'user' => $user,			
		]);
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountsModel  $accountsModel
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountModel $accountModel)
    {
		$accounts = $user->accounts()->get();
		return view('usuarios.editAccount', [
			'account' => $accountModel,
			'accounts' => $accounts,
		]);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountsModel  $accountsModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountModel $accountModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountsModel  $accountsModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountModel $accountModel)
    {
        //
    }
}
