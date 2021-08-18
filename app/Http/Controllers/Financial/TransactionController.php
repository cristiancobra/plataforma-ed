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
    public function index(Request $request) {
        $monthStart = date('Y-m-01');
        $monthEnd = date('Y-m-t');

        $transactions = Transaction::filterTransactions($request);

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = User::myUsers();

        $revenueMonthly = Transaction::where('account_id', auth()->user()->account_id)
                ->where('type', 'crédito')
                ->whereBetween('pay_day', [$monthStart, $monthEnd])
                ->sum('value');

        $estimatedRevenueMonthly = Invoice::where('account_id', auth()->user()->account_id)
                ->where('type', 'receita')
                ->where('status', 'aprovada')
                ->whereBetween('pay_day', [$monthStart, $monthEnd])
                ->sum('installment_value');

        $expenseMonthly = Transaction::where('account_id', auth()->user()->account_id)
                ->where('type', 'débito')
                ->whereBetween('pay_day', [$monthStart, $monthEnd])
                ->sum('value');

        $estimatedExpenseMonthly = Invoice::where('account_id', auth()->user()->account_id)
                ->where('type', 'despesa')
                ->where('status', 'aprovada')
                ->whereBetween('pay_day', [$monthStart, $monthEnd])
                ->sum('installment_value');

        $bankAccounts = BankAccount::where('account_id', auth()->user()->account_id)
                ->get();

        foreach ($bankAccounts as $key => $bankAccount) {
            $subTotal[$key] = Transaction::where('bank_account_id', $bankAccount->id)
                    ->sum('value');

            $bankAccount->balance = $bankAccount->opening_balance + $subTotal[$key];
        }

        $trashStatus = request('trash');

        return view('financial.transactions.index', compact(
                        'transactions',
                        'contacts',
                        'companies',
                        'users',
                        'bankAccounts',
                        'revenueMonthly',
                        'estimatedRevenueMonthly',
                        'expenseMonthly',
                        'estimatedExpenseMonthly',
                        'trashStatus',
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
            $transaction->account_id = auth()->user()->account_id;
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
                $transaction->account_id = auth()->user()->account_id;
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
    public function show(Transaction $transaction, Request $request) {
        $type = $request->type;

        return view('financial.transactions.show', compact(
                        'transaction',
                        'type',
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

        $bankAccounts = BankAccount::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

        $invoices = Invoice::where('account_id', auth()->user()->account_id)
                ->where('status', 'aprovada')
                ->where('type', 'LIKE', $typeTransactions)
                ->orderBy('pay_day', 'ASC')
                ->get();

        $users = User::myUsers();

        return view('financial.transactions.edit', compact(
                        'transaction',
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

        return redirect()->route('transaction.show', compact('transaction'));
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

    public function sendToTrash(Transaction $transaction) {
        $transaction->trash = 1;
        $transaction->save();

        return redirect()->back();
    }

    public function restoreFromTrash(Transaction $transaction) {
        $transaction->trash = 0;
        $transaction->save();

        return redirect()->back();
    }

    public function exportCsv(Request $request) {
        $fileName = 'transactions.csv';
        $transactions = Transaction::where('account_id', auth()->user()->account_id)
                ->with([
                    'invoice',
                    'user.contact',
                ])
                ->orderBy('pay_day', 'DESC')
                ->get();

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('ID', 'DATA', 'USUÁRIO', 'OBSERVAÇÕES', 'FATURA', 'MÉTODO DE PAGAMENTO', 'CONTA BANCÁRIA', 'VALOR');

        $callback = function () use ($transactions, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, $separator = ";");

            foreach ($transactions as $transaction) {
                $row['ID'] = $transaction->id;
                $row['DATA'] = $transaction->pay_day;
                $row['USUÁRIO'] = $transaction->user->contact->name;
                $row['OBSERVAÇÕES'] = $transaction->observations;
                if ($transaction->invoice) {
                    $row['FATURA'] = $transaction->invoice->identifier;
                } else {
                    $row['FATURA'] = 'não possui';
                }
                $row['MÉTODO DE PAGAMENTO'] = $transaction->payment_method;
                $row['CONTA BANCÁRIA'] = $transaction->bankAccount->name;
                $row['VALOR'] = str_replace('.', ',', $transaction->value);

                fputcsv($file, array($row['ID'], $row['DATA'], $row['USUÁRIO'], $row['OBSERVAÇÕES'], $row['FATURA'], $row['MÉTODO DE PAGAMENTO'], $row['CONTA BANCÁRIA'], $row['VALOR']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
