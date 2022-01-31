<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class SetProductsStatusAtivadaDesativada extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:activate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza a situação (status) de PRODUTOS para ativada ou desativda';

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
$products = Contact::all();

        foreach ($products as $product) {
            switch ($product->status) {
                case 'ativo';
                    $product->status = 'ativada';
                    break;
                default;
                    $product->status = 'ativada';
                    break;
            }
            $product->save();
        }
    }

}