<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;

class ConvertDateInTimestamp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:dateTimestamp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Converte a coluna DATE_DUE em timestamp';

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
        $tasks = Task::all();
        
        foreach($tasks as $task) {
            $date = strtotime($task->date_due);   
            $task->date_due = date('Y-m-d 00:00:00', $date);
//            $task->save();
        }
    }
}
