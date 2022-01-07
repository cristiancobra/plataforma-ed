<?php

namespace App\View\Components\Sections;

use Illuminate\View\Component;
use App\Models\BankAccount;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\User;

class Transactions extends Component {

    public $invoice;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($invoice) {
        $this->invoice = $invoice;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        $invoice = $this->invoice;
        dd($invoice);
//        if ($invoice) {
            $transactionFrameColor = auth()->user()->account->principal_color;

            $allTransactions = Transaction::where('invoice_id', $invoice->id)
                    ->orderBy('PAY_DAY', 'ASC')
                    ->get();

            $transactions = $allTransactions->where('trash', '!=', 1);
            $deletedTransactions = $allTransactions->where('trash', '==', 1);

            $transactionsCount = $transactions->count();
            
//            $transactionsTotal = 0;
//            $balanceTotal = 0;
//
//            foreach ($transactions as $transaction) {
//
//                if ($transaction->status == 'aprovada') {
//                    $transaction->paid = Transaction::where('invoice_id', $transaction->id)
//                            ->where('trash', '!=', 1)
//                            ->sum('value');
//                }
//                if ($transaction->paid >= $invoice->totalPrice) {
//                    $transaction->status = 'paga';
//                } elseif ($transaction->paid > 0 AND $transaction->paid <= $invoice->totalPrice) {
//                    $transaction->status = 'parcial';
//                }
//
//                $transaction->balance = $transaction->totalPrice - $transaction->paid;
//
//                $transactionsTotal += $transaction->totalPrice;
//                $balanceTotal += $transaction->balance;
//            }
//
//
//            $invoiceInstallmentsTotal = $invoices->where('status', 'aprovada')->sum('installment_value');
//            $invoicePaymentsTotal = $invoices->sum('balance');
//            $balanceTotal = $invoiceInstallmentsTotal + $invoicePaymentsTotal;
//        } else {
//            $invoices = [];
//            $invoiceInstallmentsTotal = 0;
//            $invoicePaymentsTotal = 0;
//            $transactionsTotal = 0;
//            $balanceTotal = 0;
//            $invoicesCount = 0;
            $invoiceFrameColor = 'lightgray';
            dd($invoiceFrameColor);
//        }

        $counterInvoices = 1;
        $counterTransactions = 1;
        $users = User::myUsers();

        $bankAccounts = BankAccount::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        return view('components.sections.transactions', compact(
                        'invoice',
                        'invoices',
                        'deletedInvoices',
                        'invoiceInstallmentsTotal',
                        'invoicePaymentsTotal',
                        'transactionsTotal',
                        'balanceTotal',
                        'invoicesCount',
                        'invoiceFrameColor',
                        'counterInvoices',
                        'counterTransactions',
                        'users',
                        'bankAccounts',
        ));
    }

}
