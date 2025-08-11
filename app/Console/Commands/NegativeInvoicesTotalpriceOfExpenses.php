<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;

class NegativeInvoicesTotalpriceOfExpenses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:negative';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transforma o valor total das faturas positivas em negativas';

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
      $invoices = Invoice::where('type', 'despesa')->get();
      
      foreach($invoices as $invoice) {
          $invoice->totalPrice = $invoice->totalPrice * -1;
          $invoice->save();
      }
    }
}
