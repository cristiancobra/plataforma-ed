<?php

namespace App\Http\Controllers\Administrative\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Company;
use App\Models\InvoiceLine;
use App\Models\Image;
use App\Models\Product;
use App\Models\Socialmedia;
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

        $total = $accounts->count();

        return view('administrative.accounts.index', compact(
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

        return view('administrative.accounts.create', compact(
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

        return redirect()->action('Administrative\\Accounts\\AccountController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account) {
        $productsPlataforma = [4, 65, 67, 73];
        $invoiceLines = InvoiceLine::whereHas('product', function ($query) use ($productsPlataforma) {
                    $query->whereIn('product_id', $productsPlataforma);
                })
                ->with('invoice')
                ->get();
//                dd($invoiceLines);

        return view('administrative.accounts.show', compact(
                        'account',
                        'invoiceLines',
        ));
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
        $status = Account::returnStatus();
        $users = myUsers();
        $logos = $this->logos();
        $businessModelTypes = Account::businessModelTypes();

        return view('administrative.accounts.edit', compact(
                        'users',
                        'usersChecked',
                        'account',
                        'states',
                        'status',
                        'logos',
                        'businessModelTypes',
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

    public function dashboard(Account $account) {
        $providers = Company::where('account_id', auth()->user()->account_id)
                ->where('type', 'fornecedor')
                ->get();
        
        $revenues = Product::where('account_id', auth()->user()->account_id)
                ->where('type', 'receita')
//                ->where('category', 'serviço')
                ->where('status', 'disponível')
                ->get();
        
        $expenses = Product::where('account_id', auth()->user()->account_id)
                ->where('type', 'despesa')
//                ->where('category', 'serviço')
                ->where('status', 'disponível')
                ->get();
        
        $socialmedias= Socialmedia::where('account_id', auth()->user()->account_id)
                ->where('type', 'minha')
                ->get();
        
        return view('administrative.accounts.dashboard', compact(
                        'account',
                        'providers',
                        'revenues',
                        'expenses',
                        'socialmedias',
        ));
    }

    public function logos() {
        $logos = Image::where('type', 'logo')->get();
        return $logos;
    }

}