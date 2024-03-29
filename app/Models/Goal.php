<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Goal extends Model {

    protected $table = 'goals';
    protected $fillable = [
        'id',
        'account_id',
        'department',
        'name',
        'description',
        'opportunity_id',
        'date_start',
        'date_due',
        'date_conclusion',
        'goal_contacts',
        'goal_points',
        'goal_invoices_revenues',
        'goal_invoices_expenses',
        'goal_transactions_expenses',
        'goal_transactions_revenues',
        'goal_opportunities',
        'goal_opportunities_won',
        'type',
        'trash',
        'status',
    ];
    protected $hidden = [
    ];

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

//    public function opportunities() {
//        return $this->hasMany(Opportunity, 'goal_id', 'id');
//    }
    
    public function tasks() {
        return $this->hasMany(Task::class, 'stage_id', 'id');
    }

// MÉTODOS PÚBLICOS


    public static function filterGoals(Request $request) {
        $goals = Goal::where(function ($query) use ($request) {
                    $query->where('account_id', auth()->user()->account_id);
                    if ($request->name) {
                        $query->where('name', 'like', "%$request->name%");
                    }
                    if ($request->department) {
                        $query->where('department', $request->department);
                    }
                    if ($request->date_due) {
                        $query->where('date_due', '<', $request->date_due);
                    }
                    if ($request->priority) {
                        $query->where('priority', $request->priority);
                    }
                    if ($request->type) {
                        $query->where('type', $request->type);
                    }
                    if ($request->status == '') {
                        // busca todos
                    } elseif ($request->status == 'fazendo') {
                        $query->where('status', 'fazer');
                        $query->whereHas('journeys');
                    } elseif ($request->status) {
                        $query->where('status', $request->status);
                    }
                    if ($request->trash == 1) {
                        $query->where('trash', 1);
                    } else {
                        $query->where('trash', '!=', 1);
                    }
                })
//                ->with(
//                        'opportunity',
//                        'journeys',
//                        'user.contact',
//                        'user.image',
//                        'images',
//                )
//                ->orderByRaw(DB::raw("FIELD(status, 'fazer', 'aguardar', 'cancelada', 'feito')"))
                ->orderBy('date_due', 'DESC')
                ->paginate(20);

        $goals->appends([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return $goals;
    }

    public static function returnTypes() {
        return [
            'execução',
            'receitas',
            'despesas',
            'entradas',
            'saídas',
        ];
    }

    public static function returnStatus() {
        return [
            'ativada',
            'desativada',
        ];
    }

//    retorna o valor da meta de acordo com o tipo da meta
    public static function goalSelected($goal) {
//        dd($goal);
        switch ($goal->type) {
            case 'execução';
                $projects = Project::where('goal_id', $goal->id)
                        ->with('tasks')
                        ->get();

                if (count($projects) <= 0) {
                    $goalSelected = 'Adicione todos os projetos e tarefas para saber sua meta';
                } else {
                    $sumDuration = 0;
                    foreach($projects as $project) {
//                        dd($projects);
                        foreach($project->tasks as $task) {
                            $sumDuration = $sumDuration + $task->duration;
//                            dd($sumDuration);
                        }
                    }
                    
                    if($sumDuration) {
                    $goalSelected = "Concluir $sumDuration pontos";
                    } else {
                        $goalSelected = 'Adicione todos os projetos e tarefas para saber sua meta';
                    }
                }
                break;
            case 'contatos';
                $goalSelected = "Capturar $goal->goal_contacts contatos";
                break;
            case 'receita';
                $goalSelected = formatCurrencyReal($goal->goal_invoices_revenues);
                break;
            case 'despesa';
                $goalSelected = formatCurrencyReal($goal->goal_invoices_expenses);
                break;
            case 'entrada';
                $goalSelected = formatCurrencyReal($goal->goal_transactions_revenues);
                break;
            case 'saída';
                $goalSelected = formatCurrencyReal($goal->goal_transactions_expenses);
                break;
        }

        return $goalSelected;
    }

//    retorna as metas abertas
    public static function openGoals() {
        return Goal::where('account_id', auth()->user()->account_id)
                        ->where('status', 'ativada')
                        ->get();
    }

    // método que retorna o resultado de uma meta
    static function goalResult($goal) {
        switch($goal->type) {
            case 'execução';
                $projects = Opportunity::where('goal_id', $goal->id)
                        ->with('tasks')
                        ->get();

                if (count($projects) >= 0) {
                    $goalResult = 'Adicione todos os projetos e tarefas para saber sua meta';
                } else {
                    foreach($projects as $project) {
                        foreach($project->tasks as $task) {
                            $sumDuration = $sumDuration + $task->duration;
//                            dd($sumDuration);
                        }
                    }
                    $goalResult = "Concluir $sumDuration pontos";
                }
                break;
            case 'contatos';
                $goalResult = "Capturar $goal->goal_contacts contatos";
                break;
            case 'receita';
                $goalResult = formatCurrencyReal($goal->goal_invoices_revenues);
                break;
            case 'despesa';
                $goalResult = formatCurrencyReal($goal->goal_invoices_expenses);
                break;
            case 'entrada';
                $goalResult = formatCurrencyReal($goal->goal_transactions_revenues);
                break;
            case 'saída';
                $goalResult = formatCurrencyReal($goal->goal_transactions_expenses);
                break;
        }

        return $goalResult;
    }
    
    
    public static function getProjectsOfGoal($goalId) {
        return Opportunity::where('goal_id', $goalId)
//                ->where('department', 'desenvolvimento')
                ->where('trash', '!=', 1)
                ->with([
                    'tasks',
                ])
                ->orderBy('date_start', 'DESC')
                ->get();
        ;
    }
}
