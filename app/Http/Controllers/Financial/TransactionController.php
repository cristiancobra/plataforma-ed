<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\BankAccount;
use App\Models\Contact;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\User;

class TransactionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $monthStart = date('Y-m-01');
        $monthEnd = date('Y-m-t');

        $transactions = Transaction::where('account_id', auth()->user()->account_id)
                ->with([
                    'user',
                    'bankAccount',
                    'invoice',
                    'invoice.company',
                ])
                ->orderBy('PAY_DAY', 'DESC')
                ->paginate(20);

        $contacts = Contact::whereIn('account_id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->get();

        $companies = Company::whereIn('account_id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->get();

        $accounts = Account::whereIn('id', userAccounts())
                ->orderBy('ID', 'ASC')
                ->get();

        $users = User::myUsers();

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
            $subTotal[$key] = Transaction::where('bank_account_id', $bankAccount->id)
                    ->sum('value');

            $bankAccount->balance = $bankAccount->opening_balance + $subTotal[$key];
        }
//dd($transactions);
        return view('financial.transactions.index', compact(
                        'transactions',
                        'contacts',
                        'companies',
                        'accounts',
                        'users',
                        'bankAccounts',
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

        $bankAccounts = BankAccount::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

        $invoices = Invoice::where('account_id', auth()->user()->account_id)
                ->where('status', 'aprovada')
                ->where('type', 'LIKE', $typeTransactions)
                ->orderBy('pay_day', 'ASC')
                ->paginate(20);

        $users = User::myUsers();

        return view('financial.transactions.create', compact(
                        'typeTransactions',
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
            if ($transaction->type == 'crédito') {
                $transaction->value = removeCurrency($request->value);
            } else {
                $transaction->value = removeCurrency($request->value) * -1;
            }
//            dd($transaction);
            $transaction->save();

            if ($transaction->type == 'transferência') {
                $transaction2 = new Transaction();
                $transaction2->fill($request->all());
                $transaction2->bank_account_id = $request->bank_account_destiny_id;
                $transaction2->value = removeCurrency($request->value);
                $transaction2->save();
            };

            return redirect()->route('transaction.show', compact('transaction'));
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

        $users = User::myUsers();

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

    public function filter(Request $request) {
        $monthStart = date('Y-m-01');
        $monthEnd = date('Y-m-t');

        $transactions = Transaction::where(function ($query) use ($request) {
                    if ($request->account_id) {
                        $query->where('account_id', $request->account_id);
                    } else {
                        $query->whereIn('account_id', userAccounts());
                    }
                    if ($request->name) {
                        $query->whereHas('opportunity', function ($query) use ($request) {
                            $query->where('name', 'like', "%$request->name%");
                        });
                    }
                    if ($request->date_start) {
                        $query->where('pay_day', '>', $request->date_start);
                    }
                    if ($request->date_end) {
                        $query->where('pay_day', '<', $request->date_end);
                    }
                    if ($request->bank_account_id) {
                        $query->where('bank_account_id', $request->bank_account_id);
                    }
                    if ($request->company_id) {
                        $query->where('company_id', $request->company_id);
                    }
//                    if ($request->status) {
//                        $query->where('status', '=', $request->status);
//                    }
                    if ($request->type) {
                        $query->where('type', '=', $request->type);
                    }
                })
                ->with([
                    'user',
                    'bankAccount',
                    'invoice',
                    'invoice.company',
                    'invoice.opportunity',
                ])
                ->orderBy('pay_day', 'DESC')
                ->paginate(20);

        $transactions->appends([
            'status' => $request->status,
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
        ]);

        $contacts = Contact::whereIn('account_id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->get();

        $companies = Company::whereIn('account_id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->get();

        $accounts = Account::whereIn('id', userAccounts())
                ->orderBy('ID', 'ASC')
                ->get();

        $users = User::myUsers();

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
            $subTotal[$key] = Transaction::where('bank_account_id', $bankAccount->id)
                    ->sum('value');

            $bankAccount->balance = $bankAccount->opening_balance + $subTotal[$key];
        }
//dd($transactions);
        return view('financial.transactions.index', compact(
                        'transactions',
                        'contacts',
                        'companies',
                        'accounts',
                        'users',
                        'bankAccounts',
                        'revenueMonthly',
                        'estimatedRevenueMonthly',
                        'expenseMonthly',
                        'estimatedExpenseMonthly',
        ));
    }

}
