<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FillNullFieldCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:fill-null';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Preenche campos com valor null com NÃO SEI';

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
        $models = Contact::where('lead_source', null)
                ->get();
        
    foreach($models as $model) {
        if($model->lead_source == null) {
            $model->lead_source = 'não sei';
        }
    }
        
    }
}
