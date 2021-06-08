<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Image;
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
            $accounts = Account::whereHas('users', function ($query) {
                        $query->where('users.id', Auth::user()->id);
                    })
                    ->with('image')
                    ->paginate(20);
//dd($accounts);
            $total = $accounts->count();

            return view('accounts.indexAccounts', compact(
                            'accounts',
                            'total',
            ));
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $users = User::whereHas('accounts', function ($query) {
                    $query->whereIn('accounts.id', userAccounts());
                })
                ->get();

        $states = returnStates();
        $logos = $this->logos();

        return view('accounts.create', compact(
                        'users',
                        'states',
                        'logos',
        ));
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
        $users = myUsers();
        $logos = $this->logos();

        return view('accounts.edit', compact(
                        'users',
                        'usersChecked',
                        'account',
                        'states',
                        'logos',
        ));
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

        return redirect()->route('account.show', compact(
            'account',
        ));
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

    public function logos() {
        $logos = Image::where('type', 'logo')->get();
        return $logos;
    }
}
