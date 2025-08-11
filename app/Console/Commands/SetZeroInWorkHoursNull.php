<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class SetZeroInWorkHoursNull extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:zeroHours';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atribui zero na coluna WORK HOURS quando o valor for nulo';

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
      $products = Product::where('work_hours', null)->get();
      
      foreach($products as $products) {
          $products->work_hours = 0;
          $products->save();
      }
    }
}

