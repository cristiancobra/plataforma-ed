<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use App\Models\Opportunity;
use App\Models\ProductProposal;
use App\Models\Proposal;

class CreateProposalsFromInvoices extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:proposalsFromInvoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migração do modelo antigo de faturas para propostas com faturas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $opportunities = Opportunity::where('id', '>', 1)
                ->with('invoices.invoiceLines')
                ->get();

        foreach ($opportunities as $opportunity) {
            foreach ($opportunity->invoices as $invoice) {

                if ($invoice->number_installment == 1) {
                    $proposal = new Proposal();
                    $proposal->identifier = $invoice->identifier;
                    $proposal->account_id = $invoice->account_id;
                    $proposal->user_id = $invoice->user_id;
                    $proposal->opportunity_id = $invoice->opportunity_id;
                    $proposal->company_id = $invoice->company_id;
                    $proposal->contact_id = $invoice->contact_id;
                    $proposal->date_creation = $invoice->date_creation;
                    $proposal->pay_day = $invoice->pay_day;
                    $proposal->description = $invoice->description;
                    $proposal->discount = $invoice->discount;
                    $proposal->totalHours = $invoice->totalHours;
                    $proposal->totalPoints = $invoice->totalPoints;
                    $proposal->totalCost = $invoice->totalCost;
                    $proposal->totalTax_rate = $invoice->totalTax_rate;
                    $proposal->totalPrice = $invoice->totalPrice;
                    $proposal->totalMargin = $invoice->totalMargin;
                    $proposal->totalBalance = $invoice->totalBalance;
                    $proposal->receipt = $invoice->receipt;
                    $proposal->installment = $invoice->number_installment_total;
                    $proposal->type = $invoice->type;
                    $proposal->status = $invoice->status;
                    $proposal->created_at = $invoice->created_at;
                    $proposal->updated_at = $invoice->updated_at;
                    $proposal->expiration_date = $invoice->expiration_date;
                    $proposal->save();
                }
                $invoice->proposal_id = $proposal->id;
                $invoice->save();

                foreach ($invoice->invoiceLines as $invoiceLine) {
                    $productProposal = new ProductProposal();
                    $productProposal->proposal_id = $proposal->id;
                    $productProposal->product_id = $invoiceLine->product_id;
                    $productProposal->amount = $invoiceLine->amount;
                    $productProposal->subtotalHours = $invoiceLine->subtotalHours;
                    $productProposal->subtotalDeadline = $invoiceLine->subtotalDeadline;
                    $productProposal->subtotalCost = $invoiceLine->subtotalCost;
                    $productProposal->subtotalTax_rate = $invoiceLine->subtotalTax_rate;
                    $productProposal->subtotalPrice = $invoiceLine->subtotalPrice;
                    $productProposal->subtotalMargin = $invoiceLine->subtotalMargin;
                    $productProposal->created_at = $invoiceLine->created_at;
                    $productProposal->updated_at = $invoiceLine->updated_at;
                    $productProposal->save();
                    
                }
            }
        }
    }

}
