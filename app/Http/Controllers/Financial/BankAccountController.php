<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Account;
use App\Models\Bank;
use App\Models\BankAccount;

class BankAccountController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $bankAccounts = BankAccount::whereHas('account', function ($query) {
                    $query->whereIn('id', userAccounts());
                })
                ->with([
                    'account',
                    'bank',
                ])
                ->get();

//        $total = $bankAccounts->total();

        return view('financial.bankAccounts.indexBankAccounts', compact(
                        'bankAccounts',
//                        'total',
        ));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $accounts = Account::whereIn('id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->get();

        $banks = Bank::where('id', '>', 0)
                ->orderBy('NAME', 'ASC')
                ->get();

        return view('financial.bankAccounts.createBankAccount', compact(
                        'accounts',
                        'banks',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $messages = [
            'unique' => 'Já existe um contato com este :attribute.',
            'required' => '*preenchimento obrigatório.',
        ];
        $validator = Validator::make($request->all(), [
                    'name' => 'required:products',
//					'price' => 'required:products',
                        ], $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $bankAccount = new BankAccount();
            $bankAccount->fill($request->all());
            $bankAccount->save();

            $accounts = userAccounts();

            return view('financial.bankAccounts.showBankAccount', compact(
                            'bankAccount',
                            'accounts',
            ));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function show(BankAccount $bankAccount) {

        return view('financial.bankAccounts.showBankAccount', compact(
                        'bankAccount',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(BankAccount $bankAccount) {
        $accounts = userAccounts();

        $banks = Bank::where('id', '>', 0)
                ->orderBy('NAME', 'ASC')
                ->get();
//		dd($banks);

        return view('financial.bankAccounts.editBankAccount', compact(
                        'bankAccount',
                        'accounts',
                        'banks',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankAccount $bankAccount) {
        $bankAccount->fill($request->all());
        $bankAccount->save();

        return view('financial.bankAccounts.showBankAccount', compact(
                        'bankAccount',
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankAccount $bankAccount) {
        $bankAccount->delete();
        return redirect()->action('Financial\\BankAccountController@index');
    }

}
