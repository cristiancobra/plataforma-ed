<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class NegativeProductDespesaPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:negative';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transforma o valor de produtos do tipo DESPESA que são positivas em negativas';

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
      $products = Product::where('type', 'despesa')->get();
      
      foreach($products as $products) {
          $products->price = $products->price * -1;
          $products->save();
      }
    }
}
