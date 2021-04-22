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
    public function index() { {
            $accounts = Account::whereHas('users', function ($query) {
                        $query->where('users.id', Auth::user()->id);
                    })
                    ->paginate(20);

            $total = $accounts->count();

            return view('accounts.indexAccounts', compact(
                            'accounts',
                            'total',
            ));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $states = returnStates();

        if ($request['role'] === "superadmin") {
            $users = User::where('users.id', '>', 0)
                    ->join('contacts', 'contacts.id', '=', 'users.contact_id')
                    ->orderBy('NAME', 'asc')
                    ->get();

            return view('accounts.superadmin_createAccount', compact(
                            'users',
                            'states',
            ));
        } elseif ($request['role'] === "administrator") {
            $accountsId = userAccounts();

            $users = User::whereHas('accounts', function ($query) use ($accountsId) {
                        $query->whereIn('accounts.id', $accountsId);
                    })
                    ->get();

            return view('accounts.administrator_createAccount', compact(
                            'users',
                            'states',
            ));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $account = new \App\Models\Account();
        $account->fill($request->all());
        $account->cnpj = removeSymbols($request->cnpj);
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
    public function edit(Account $account, Request $request) {

        $usersChecked = User::whereHas('accounts', function ($query) use ($account) {
                    $query->where('account_id', $account->id);
                })
                ->pluck('id')
                ->toArray();

        $states = returnStates();

        if ($request['role'] === "superadmin") {
            $users = User::where('users.id', '>', 0)
                    ->join('contacts', 'contacts.id', '=', 'users.contact_id')
                    ->select(
                            'users.id as id',
                            'contacts.name as name',
                    )
                    ->orderBy('NAME', 'asc')
                    ->get();

            return view('accounts.superadmin_editAccount', compact(
                            'users',
                            'usersChecked',
                            'account',
                            'states',
            ));
        } elseif ($request['role'] === "administrator") {
            $accountsId = Account::whereHas('users', function ($query) {
                        $query->where('users.id', Auth::user()->id);
                    })
                    ->pluck('id');

            $users = User::whereHas('accounts', function ($query) use ($accountsId) {
                        $query->where('accounts.id', $accountsId->first());
                    })
                    ->join('contacts', 'contacts.id', '=', 'users.contact_id')
                    ->select(
                            'users.id as id',
                            'contacts.name as name',
                    )
                    ->get();
        } else {
            return redirect('/login');
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

        $account->fill($request->all());
        $account->cnpj = removeSymbols($request->cnpj);
        $account->save();
        $account->users()->sync($request->users);

        return view('accounts.showAccount', [
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
