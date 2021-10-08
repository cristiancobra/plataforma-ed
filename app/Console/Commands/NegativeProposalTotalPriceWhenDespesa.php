<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Proposal;

class NegativeProposalTotalPriceWhenDespesa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proposal:negativeTotalPrice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Negativa a coluna totalPrice de proposals quando type é igual a despesa';

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
      $proposals = Proposal::where('type', 'despesa')->get();
      
      foreach($proposals as $proposal) {
          $proposal->totalPrice = $proposal->totalPrice * -1;
          $proposal->save();
      }
    }
}
