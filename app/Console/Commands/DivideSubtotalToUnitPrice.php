<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ProductProposal;

class DivideSubtotalToUnitPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'producProposal:newPrice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Divide o subtotalPrice para encontrar o valor da nova coluna Price';

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
      $productsProposals = ProductProposal::all();
      
      foreach($productsProposals as $productProposal) {
          $productProposal->price = $productProposal->subtotalPrice / $productProposal->amount;
          $productProposal->save();
      }
    }
}
