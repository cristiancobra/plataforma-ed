<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ProductProposal;

class NegativeProductProposalPriceWhenDespesa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'producProposal:negativePrice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Negativa product_proposals price quando for do tipo despesa';

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
      $productsProposals = ProductProposal::whereHas('product', function($query) {
          $query->where('type', 'despesa');
      })
              ->get();

      foreach($productsProposals as $productProposal) {
          if($productProposal->price > 0) {
          $productProposal->price = $productProposal->price * -1;
          $productProposal->save();
      }
          if($productProposal->subtotalPrice > 0) {
          $productProposal->subtotalPrice = $productProposal->subtotalPrice * -1;
          $productProposal->save();
      }
      }
    }
}
