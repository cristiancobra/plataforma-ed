<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\BankAccount;
use App\Models\Invoice;
use App\Models\Transaction;

class TransactionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $monthStart = date('Y-m-01');
        $monthEnd = date('Y-m-t');

        $transactions = Transaction::whereIn('account_id', userAccounts())
                ->with([
                    'user',
                    'bankAccount',
                    'invoice',
                    'invoice.company',
                ])
                ->orderBy('PAY_DAY', 'DESC')
                ->paginate(20);

        $revenueMonthly = Transaction::whereIn('account_id', userAccounts())
                ->where('type', 'crédito')
                ->whereBetween('pay_day', [$monthStart, $monthEnd])
                ->sum('value');

        $estimatedRevenueMonthly = Invoice::whereIn('account_id', userAccounts())
                ->where('type', 'receita')
                ->where('status', 'aprovada')
                ->whereBetween('pay_day', [$monthStart, $monthEnd])
                ->sum('installment_value');

        $expenseMonthly = Transaction::whereIn('account_id', userAccounts())
                ->where('type', 'débito')
                ->whereBetween('pay_day', [$monthStart, $monthEnd])
                ->sum('value');

        $estimatedExpenseMonthly = Invoice::whereIn('account_id', userAccounts())
                ->where('type', 'despesa')
                ->where('status', 'aprovada')
                ->whereBetween('pay_day', [$monthStart, $monthEnd])
                ->sum('installment_value');

        $bankAccounts = BankAccount::whereIn('account_id', userAccounts())
                ->get();

        foreach ($bankAccounts as $key => $bankAccount) {
            $revenueTotal[$key] = Transaction::where('bank_account_id', $bankAccount->id)
                    ->where('type', 'crédito')
                    ->sum('value');

            $expenseTotal[$key] = Transaction::where('bank_account_id', $bankAccount->id)
                    ->where('type', 'débito')
                    ->sum('value');

            $bankAccount->revenueTotal = $bankAccount->opening_balance + $revenueTotal[$key] - $expenseTotal[$key];
        }
//dd($transactions);
        return view('financial.transactions.index', compact(
                        'bankAccounts',
                        'transactions',
                        'revenueMonthly',
                        'estimatedRevenueMonthly',
                        'expenseMonthly',
                        'estimatedExpenseMonthly',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $typeTransactions = $request->input('typeTransactions');

        $accounts = Account::whereIn('id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

        $bankAccounts = BankAccount::whereIn('account_id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

        $invoices = Invoice::whereIn('account_id', userAccounts())
                ->where('status', 'aprovada')
                ->where('type', 'LIKE', $typeTransactions)
                ->orderBy('pay_day', 'ASC')
                ->paginate(20);

        $users = myUsers();

        return view('financial.transactions.create', compact(
                        'typeTransactions',
                        'accounts',
                        'bankAccounts',
                        'invoices',
                        'users',
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
            'required' => '*preenchimento obrigatório.',
        ];
        $validator = Validator::make($request->all(), [
//					'value' => 'required:transactions',
                    'pay_day' => 'required:transactions',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $transaction = new Transaction();
            $transaction->fill($request->all());
            $transaction->value = removeCurrency($request->value);
            $transaction->save();

            return view('financial.transactions.show', compact(
                            'transaction',
            ));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction) {
//        dd($transaction);
        return view('financial.transactions.show', compact(
                        'transaction',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Transaction $transaction) {
        $typeTransactions = $request->input('typeTransactions');

        $accounts = Account::whereIn('id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

        $bankAccounts = BankAccount::whereIn('account_id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

        $invoices = Invoice::whereIn('account_id', userAccounts())
                ->where('status', 'aprovada')
                ->where('type', 'LIKE', $typeTransactions)
                ->orderBy('pay_day', 'ASC')
                ->get();

        $users = myUsers();

        return view('financial.transactions.edit', compact(
                        'transaction',
                        'accounts',
                        'bankAccounts',
                        'invoices',
                        'users',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction) {
        $transaction->fill($request->all());
        $transaction->value = removeCurrency($request->value);
        $transaction->save();

        return view('financial.transactions.show', compact(
                        'transaction',
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction) {
        $transaction->delete();
        return redirect()->action('Financial\\TransactionController@index');
    }

}
