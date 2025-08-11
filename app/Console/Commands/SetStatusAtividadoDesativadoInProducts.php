<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class SetStatusAtividadoDesativadoInProducts extends Command
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
    protected $description = 'Atualiza a situação (status) de produto para ativada ou desativda';

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
        $products = Product::all();

        foreach ($products as $product) {
            switch ($product->status) {
                case 'concluida';
                    $product->status = 'ativada';
                    break;
                case 'pendente';
                    $product->status = 'desativada';
                    break;
                case 'disponível';
                    $product->status = 'ativada';
                    break;
                case 'indisponível';
                    $product->status = 'desativada';
                    break;
            }
            $product->save();
        }
    }

}
