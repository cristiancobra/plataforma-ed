<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;

class CopyInstallmentValueToTotalPriceInInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:totalprice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copia o valor de installment_value para totalPrice em Invoices';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      $invoices = Invoice::all();
      
      foreach($invoices as $invoice) {
          $invoice->totalPrice = $invoice->installment_value;
          $invoice->save();
      }
    }
}
