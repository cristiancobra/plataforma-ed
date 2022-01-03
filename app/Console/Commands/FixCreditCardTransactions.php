<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;

class FixCreditCardTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:fixCreditCard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Altera os pagamentos inseridos como débito na conta, e transfere para o cartao de crédito da Empresa Digital';

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
        $transactions = Transaction::where('payment_method', 'cartão de crédito')
                ->where('account_id', 1)
                ->get();
        
        foreach($transactions as $transaction) {
            $transaction->bank_account_id = 18;
            $transaction->save();
        }
        
//        dd($transactions);
    }
}
