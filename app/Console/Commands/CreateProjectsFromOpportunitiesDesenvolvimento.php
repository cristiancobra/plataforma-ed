<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Opportunity;
use App\Models\Project;

class CreateProjectsFromOpportunitiesDesenvolvimento extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:createFromOpportunities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria PROJETOS a partir do modelo antigo Oportunidades tipo desenvolvimento';

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
        $opportunities = Opportunity::where('department', 'desenvolvimento')
                ->get();
        
        foreach($opportunities as $opportunity) {
        $project = new Project();
        
        $project->account_id  = $opportunity->account_id;
        $project->user_id  = $opportunity->user_id;
        $project->contact_id  = $opportunity->contact_id;
        $project->company_id  = $opportunity->company_id;
        $project->goal_id  = $opportunity->goal_id;
        $project->name  = $opportunity->name;
        $project->department  = $opportunity->department;
        $project->date_start  = $opportunity->date_start;
        $project->date_due  = $opportunity->date_due;
        $project->date_conclusion  = $opportunity->date_conclusion;
        $project->description  = $opportunity->description;
        $project->trash  = $opportunity->trash;
        $project->status  = $opportunity->status;
        $project->created_at  = $opportunity->created_at;
        $project->updated_at  = $opportunity->updated_at;
        $project->save();
        
        foreach($opportunity-stages as $stage) {
            $stage->project_id = $project->id;
        }
    }
}
}
