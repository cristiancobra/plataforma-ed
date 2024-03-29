<?php

namespace App\View\Components\Sections;

use Illuminate\View\Component;
use App\Models\BankAccount;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\User;

class Invoices extends Component {

    public $proposal;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($proposal) {
        $this->proposal = $proposal;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        $proposal = $this->proposal;
        
        if ($proposal) {
            
            if($proposal->type == 'receita') {        
        $proposal->transactionType = 'crédito';
            }else{
        $proposal->transactionType = 'débito';        
            }
            
            $invoiceFrameColor = auth()->user()->account->principal_color;

            $allInvoices = Invoice::where('proposal_id', $proposal->id)
                    ->with('transactions')
                    ->orderBy('PAY_DAY', 'ASC')
                    ->get();

            $invoices = $allInvoices->where('trash', '!=', 1);
            $deletedInvoices = $allInvoices->where('trash', '==', 1);

            $invoicesCount = $invoices->count();
            
            $invoicesTotal = 0;
            $balanceTotal = 0;

            foreach ($invoices as $invoice) {

                if ($invoice->status == 'aprovada') {
                    $invoice->paid = Transaction::where('invoice_id', $invoice->id)
                            ->where('trash', '!=', 1)
                            ->sum('value');
                }
                if ($invoice->paid >= $invoice->totalPrice) {
                    $invoice->status = 'paga';
                } elseif ($invoice->paid > 0 AND $invoice->paid <= $invoice->totalPrice) {
                    $invoice->status = 'parcial';
                }

                $invoice->balance = $invoice->totalPrice - $invoice->paid;

                $invoicesTotal += $invoice->totalPrice;
                $balanceTotal += $invoice->balance;
            }


            $invoiceInstallmentsTotal = $invoices->where('status', 'aprovada')->sum('installment_value');
            $invoicePaymentsTotal = $invoices->sum('balance');
            $balanceTotal = $invoiceInstallmentsTotal + $invoicePaymentsTotal;
        } else {
            $invoices = [];
            $deletedInvoices = [];
            $invoiceInstallmentsTotal = 0;
            $invoicePaymentsTotal = 0;
            $invoicesTotal = 0;
            $balanceTotal = 0;
            $invoicesCount = 0;
            $invoiceFrameColor = 'lightgray';
        }

        $counterInvoices = 1;
        $counterTransactions = 1;
        $users = User::myUsers();

        $bankAccounts = BankAccount::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        return view('components.sections.invoices', compact(
                        'proposal',
                        'invoices',
                        'deletedInvoices',
                        'invoiceInstallmentsTotal',
                        'invoicePaymentsTotal',
                        'invoicesTotal',
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
