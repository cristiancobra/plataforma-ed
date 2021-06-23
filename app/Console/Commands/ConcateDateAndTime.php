<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Journey;

class ConcateDateAndTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:concatedatetime';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Concatena as colunas DATE com START TIME e END TIME';

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
        $journeys = Journey::all();
        
        foreach($journeys as $journey) {
            $journey->start = $journey->date." ".$journey->start_time;
            $journey->end = $journey->date." ".$journey->end_time;
            $journey->duration = strtotime($journey->end) - strtotime($journey->start) ;
            $journey->save();
//            dd($journey);
        }
//           $start_time = strtotime($request->start_time);
//                $end_time = strtotime($request->end_time);
//                $journey->duration = $end_time - $start_time;
    }
}
