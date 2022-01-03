<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\BankAccount;
use App\Models\Contact;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Product;
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
        
        $transactionsTotal = 0; 
        foreach($transactions as $transaction) {
            $transactionsTotal += $transaction->value;
        }

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

        $types = Transaction::returnTypes();
        $trashStatus = request('trash');

        return view('financial.transactions.index', compact(
                        'transactions',
                        'transactionsTotal',
                        'contacts',
                        'companies',
                        'users',
                        'bankAccounts',
                        'revenueMonthly',
                        'estimatedRevenueMonthly',
                        'expenseMonthly',
                        'estimatedExpenseMonthly',
                        'types',
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
        if ($typeTransactions == 'débito') {
            $invoiceTotalPrice = $request->input('invoiceTotalPrice') * -1;
        } else {
            $invoiceTotalPrice = $request->input('invoiceTotalPrice');
        }

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
                        'invoiceTotalPrice',
                        'bankAccounts',
                        'invoices',
                        'users',
        ));
    }

    public function createTransfer(Request $request) {

        $bankAccounts = BankAccount::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

//        $invoices = Invoice::where('account_id', auth()->user()->account_id)
//                ->where('status', 'aprovada')
//                ->where('type', 'LIKE', $typeTransactions)
//                ->orderBy('pay_day', 'ASC')
//                ->paginate(20);

        $users = User::myUsers();

        return view('financial.transactions.transfer', compact(
//                        'typeTransactions',
//                        'invoiceTotalPrice',
                        'bankAccounts',
//                        'invoices',
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
        $typeTransactions = $request->input('typeTransactions');

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

            // verifica se o total de pagamentos é maior que o total da fatura
            $invoice = Invoice::where('id', $request->invoice_id)
                    ->with('transactions')
                    ->first();

            $totalPaid = Invoice::totalPaid($invoice);
            $newTotal = $totalPaid + $transaction->value;

            if ($transaction->type == 'crédito' AND $newTotal <= $invoice->totalPrice) {
                $transaction->save();
                return redirect()->route('transaction.show', compact('transaction'));
            } elseif ($transaction->type == 'débito' AND $newTotal >= $invoice->totalPrice) {
                $transaction->save();
                return redirect()->route('transaction.show', compact('transaction'));
            } elseif ($transaction->type == 'crédito') {
                $totalPrice = formatCurrencyReal($invoice->totalPrice);
                return back()
                                ->with('failed', "A soma dos recebimento não pode ser maior que  $totalPrice")
                                ->withInput();
            } else {
                $totalPrice = formatCurrencyReal($invoice->totalPrice);
                return back()
                                ->with('failed', "A soma dos pagamentos não pode ser menor que  $totalPrice")
                                ->withInput();
            }
        }
    }

    public function storeFromOpportunity(Request $request) {

        $messages = [
            'required' => '*preenchimento obrigatório.',
        ];
        $validator = Validator::make($request->all(), [
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

            if ($request->type == 'receita') {
                $type = 'crédito';
            } elseif ($request->type == 'despesa') {
                $type = 'débito';
            }

            if ($type == 'crédito') {
                $transaction->value = removeCurrency($request->value);
            } else {
                $transaction->value = removeCurrency($request->value) * -1;
            }


            // verifica se o total de pagamentos é maior que o total da fatura
            $invoice = Invoice::where('id', $request->invoice_id)
                    ->with('transactions')
                    ->first();

            $totalPaid = Invoice::totalPaid($invoice);
//            dd($transaction->value);
            $newTotal = $totalPaid + $transaction->value;
            if ($type == 'crédito' AND $newTotal <= $invoice->totalPrice) {
                $transaction->save();
                return redirect()->back();
            } elseif ($type == 'débito' AND $newTotal >= $invoice->totalPrice) {
                $transaction->save();
                return redirect()->back();
            } else {
                $totalPrice = formatCurrencyReal($invoice->totalPrice);
                $newTotal = formatCurrencyReal($newTotal);
                return back()
                                ->with('failed', "A soma dos pagamentos $newTotal  não pode ser maior que total da fatura  $totalPrice")
                                ->withInput();
            }
        }
    }

    public function storeTransfer(Request $request) {
        $messages = [
            'required' => '*preenchimento obrigatório.',
        ];
        $validator = Validator::make($request->all(), [
                    'pay_day' => 'required:transactions',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } elseif ($request->bank_account_id == $request->bank_account_destiny_id) {
            return back()
                            ->with('failed', "As contas de origem e destino não podem ser iguais.")
                            ->withInput();
        } else {
            $transaction = new Transaction();
            $transaction->fill($request->all());
            $transaction->type = 'transferência';
            $transaction->account_id = auth()->user()->account_id;
            $transaction->value = removeCurrency($request->value) * -1;
            $transaction->save();

            $transaction2 = new Transaction();
            $transaction2->fill($request->all());
            $transaction2->account_id = auth()->user()->account_id;
            $transaction2->bank_account_id = $request->bank_account_destiny_id;
            $transaction2->type = 'transferência';
            $transaction2->value = removeCurrency($request->value);
            $transaction2->save();
//            dd($transaction2);

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
        if ($typeTransactions == 'débito') {
            $transaction->value = $transaction->value * -1;
        }

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
        $typeTransactions = $request->input('typeTransactions');
        $oldTransactionValue = $transaction->value;

        $transaction->fill($request->all());
        $transaction->value = removeCurrency($request->value);
        if ($typeTransactions == 'débito') {
            $transaction->value = $transaction->value * -1;
        }

        // verifica se o total de pagamentos é maior que o total da fatura
        $invoice = Invoice::where('id', $request->invoice_id)
                ->with('transactions')
                ->first();

        $totalPaid = Invoice::totalPaid($invoice) - $oldTransactionValue;
        $newTotal = $totalPaid + $transaction->value;

        if ($newTotal >= $invoice->totalPrice) {
            $transaction->save();

            return redirect()->route('transaction.show', compact('transaction'));
        } else {
            if ($typeTransactions == 'débito') {
                $totalPrice = formatCurrencyReal($invoice->totalPrice * -1);
            } else {
                $totalPrice = formatCurrencyReal($invoice->totalPrice);
            }
            return back()
                            ->with('failed', "A soma dos pagamentos não pode ser maior que  $totalPrice")
                            ->withInput();
        }
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

    public function report(Request $request) {
        $months = returnMonths();
        $pastMonths = date('m');

        if (isset($request->year)) {
            $year = $request->year;
        } else {
            $year = date('y');
        }

//   RECEITAS
        $monthlyRevenues = Transaction::monthlyTransactionsTotal($year, 'crédito');
        $annualRevenues = Invoice::annualInvoicesTotal($year, 'crédito');

//        $categoriesNames = Product::returnCategories();
//        $categories = [];
//        foreach ($categoriesNames as $category) {
//            $categories[$category]['name'] = $category;
//            $categories[$category]['monthlys'] = Transaction::monthlysCategoriesTotal($year, $category, 'crédito');
//            $categories[$category]['year'] = Invoice::annualCategoriesTotal($year, $category, 'crédito');
//        }

//
        // DESPESAS
        $monthlyExpenses = Transaction::monthlyTransactionsTotal($year, 'débito');
        $annualExpenses = Invoice::annualInvoicesTotal($year, 'débito');
        
        // SALDO
        $monthlysTotals = Transaction::monthlyTransactionsBalance($year);
        $annualTotal = Invoice::annualInvoicesTotal($year);
        
//        $groupsName = Product::returnGroups();
//        $groups = [];
//        foreach ($groupsName as $group) {
//            $groups[$group]['name'] = $group;
//            $groups[$group]['monthlys'] = Transaction::monthlysGroupsTotal($year, $group, 'débito');
//            $groups[$group]['year'] = Invoice::annualGroupsTotal($year, $group, 'débito');
//        }

        // Gráfico
        $chartBackgroundColors = [
            'rgba(255, 206, 86, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(41, 221, 101, 0.2)',
            'rgba(255, 99, 132, 0.2)',
        ];

        $chartBorderColors = [
            'rgba(255, 206, 86, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(41, 221, 101, 1)',
            'rgba(255, 99, 132, 1)',
        ];

        return view('financial.transactions.report', compact(
                        'year',
                        'months',
                        'monthlyRevenues',
//                        'categories',
//                        'categoriesNames',
//                        'groups',
                        'annualRevenues',
                        'monthlyExpenses',
                        'annualExpenses',
                        'monthlysTotals',
                        'annualTotal',
                        'chartBackgroundColors',
                        'chartBorderColors',
        ));
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
