<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Account;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Transaction;

class BankAccountController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $bankAccounts = BankAccount::where('account_id', auth()->user()->account_id)
                ->with([
                    'account',
                    'bank',
                ])
                ->get();

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
        $banks = Bank::where('id', '>', 0)
                ->orderBy('NAME', 'ASC')
                ->get();

        return view('financial.bankAccounts.createBankAccount', compact(
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

            return view('financial.bankAccounts.showBankAccount', compact(
                            'bankAccount',
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
        $bankAccount->transactions = Transaction::where('bank_account_id', $bankAccount->id)
                ->orderBy('PAY_DAY', 'DESC')
                ->get();
        
        $bankAccount->balance = $bankAccount->transactions->sum('value') + $bankAccount->opening_balance;
//
//            foreach ($bankAccounts as $key => $bankAccount) {
//                $subTotal[$key] = Transaction::where('bank_account_id', $bankAccount->id)
//                    ->where('type', 'crédito')
//                        ->sum('value');

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
        $banks = Bank::where('id', '>', 0)
                ->orderBy('NAME', 'ASC')
                ->get();

        return view('financial.bankAccounts.editBankAccount', compact(
                        'bankAccount',
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
