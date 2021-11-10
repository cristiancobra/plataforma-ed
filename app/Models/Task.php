<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use Illuminate\Http\Request;
use App\Models\User;
use DateTime;
use DateInterval;

class Task extends Model {

    protected $table = 'tasks';
    protected $fillable = [
        'id',
        'user_id',
        'company_id',
        'account_id',
        'contact_id',
        'opportunity_id',
        'stage_id',
        'date_entered',
        'created_by',
        'name',
        'department',
        'description',
        'date_due',
        'date_start',
        'date_conclusion',
        'status',
        'priority',
        'start_time',
        'end_time',
        'duration',
        'points',
        'type',
    ];
    protected $hidden = [
    ];

    // RELACIONAMENTOS

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function contact() {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function images() {
        return $this->hasMany(Image::class, 'task_id', 'id');
    }

    public function journeys() {
        return $this->hasMany(Journey::class, 'task_id', 'id');
    }

    public function opportunity() {
        return $this->hasOne(Opportunity::class, 'id', 'opportunity_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // MÉTODOS PÚBLICO


    public static function filterTasks(Request $request) {
        $tasks = Task::where(function ($query) use ($request) {
                    $query->where('account_id', auth()->user()->account_id);
                    if ($request->user_id) {
                        $query->where('user_id', $request->user_id);
                    }
                    if ($request->name) {
                        $query->where('name', 'like', "%$request->name%");
                    }
                    if ($request->department) {
                        $query->where('department', $request->department);
                    } else {
                        $query->where('department', '!=', 'tarefa pessoal');
                    }
                    if ($request->contact_id) {
                        $query->where('contact_id', $request->contact_id);
                    }
                    if ($request->company_id) {
                        $query->where('company_id', $request->company_id);
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
                ->with(
                        'opportunity',
//                        'journeys',
                        'user.contact',
                        'user.image',
                        'images',
                )
//                ->orderByRaw(DB::raw("FIELD(status, 'fazer', 'aguardar', 'cancelada', 'feito')"))
                ->orderBy('date_due', 'DESC')
                ->paginate(20);

        $tasks->appends([
            'name' => $request->name,
            'status' => $request->status,
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
        ]);

        return $tasks;
    }
    
//    
//    public static function myOpenTask() {
//        return Task::where('user_id', auth()->user()->id)
//                        ->where('end', null)
//                        ->with('journeys')
//                        ->orderBy('id', 'DESC')
//                        ->first();
//    }

    static function returnDepartments() {
        return $departments = array(
            'administrativo',
            'atendimento',
            'desenvolvimento',
            'financeiro',
            'marketing',
            'produção',
            'vendas',
            'tarefa pessoal',
        );
    }

// retorna prioridade
    static function returnPriorities() {
        return $priorities = array(
            'baixa',
            'média',
            'alta',
            'emergência',
        );
    }

// retorna os módulos da plataforma quando for reportar bugs
    static function returnBugModules() {
        return $priorities = array(
            'não sei',
            'administrativo',
            'financeiro',
            'marketing',
            'vendas',
            'jurídico',
            'produção',
            'menu',
            'painel',
        );
    }

// retorna os módulos da plataforma quando for reportar bugs
    static function returnBugActions() {
        return $priorities = array(
            'não sei',
            'cliquei num item do menu',
            'tentei criar/salvar algo',
            'tentei editar uma informação',
            'vi uma informação errada',
            'problema no layout/visual',
            'sugestão de nova funcionalidade',
        );
    }
    
    
    static function returnStatus() {
        return $status = array(
            'fazer',
            'aguardar',
            'feito',
            'fazendo',
            'cancelado',
        );
    }


    // retorna a última tarefa feita pelo usuário logado
    public static function myLastTask() {
        return Task::latest()
                        ->where('user_id', auth()->user()->id)
                        ->first();
    }

    // retorna a última tarefa feita do usuário indicado
    public static function userLastTask($user) {
        return Task::where('user_id', $user->id)
                        ->orderBy('date_conclusion', 'DESC')
                        ->first();
    }


    public static function completeTask(Task $task) {
        $dateNow = new DateTime('now');
        $task->date_conclusion = $dateNow->format('Y-m-d H:i');
        $task->status = 'feito';
        $task->save();

        return $task;
    }
    
    public static function getTasksEmergency() {
        return Task::where('account_id', auth()->user()->account_id)
                ->where('user_id', auth()->user()->id)
                ->where('priority', 'emergência')
                ->where('status', 'fazer')
                ->where('trash', '!=', 1)
                ->get();
    }
    
    public static function countTasksEmergency() {
        return Task::where('account_id', auth()->user()->account_id)
                ->where('user_id', auth()->user()->id)
                ->where('priority', 'emergência')
                ->where('status', 'fazer')
                ->where('trash', '!=', 1)
                ->count();
    }
    
    public static function countUserTasks($user) {
        return Task::where('user_id', $user->id)
                ->where('status', 'fazer')
                ->where('trash', '!=', 1)
                ->count();
    }
    
    public static function countUserTasksLates($user) {
        return Task::where('user_id', $user->id)
                ->where('date_due', '<', date('Y-m-d'))
                ->where('status', 'fazer')
                ->where('trash', '!=', 1)
                ->count();
    }
    
    public static function countUserEmergencies($user) {
        return Task::where('user_id', $user->id)
                ->where('priority', 'emergência')
                ->where('status', 'fazer')
                ->where('trash', '!=', 1)
                ->count();
    }
    
    public static function countUserHigh($user) {
        return Task::where('user_id', $user->id)
                ->where('priority', 'alta')
                ->where('status', 'fazer')
                ->where('trash', '!=', 1)
                ->count();
    }
    
    public static function countUserMedium($user) {
        return Task::where('user_id', $user->id)
                ->where('priority', 'média')
                ->where('status', 'fazer')
                ->where('trash', '!=', 1)
                ->count();
    }
    
    public static function countUserLow($user) {
        return Task::where('user_id', $user->id)
                ->where('priority', 'baixa')
                ->where('status', 'fazer')
                ->where('trash', '!=', 1)
                ->count();
    }
    
    // cria uma nova TAREFA para entrar em contato com o novo usuário registrado
    public static function registerTaskOpportunity($contactEd, $companyEd, $opportunityEd) {
            $taskOpportunity = new Task();
            $taskOpportunity->name = "Fazer primeiro contato com $contactEd->name";
            $taskOpportunity->account_id = 1;
            $taskOpportunity->contact_id = $contactEd->id;
            $taskOpportunity->company_id = $companyEd->id;
            $taskOpportunity->user_id = 2;
            $taskOpportunity->department = 'vendas';
            $taskOpportunity->opportunity_id = $opportunityEd->id;
            $taskOpportunity->date_start = date('Y-m-d');
            $today = new Datetime('now');
            $today->add(new DateInterval('P2D'));
            $taskOpportunity->date_due = $today;
            $taskOpportunity->priority = 'alta';
            $taskOpportunity->status = 'fazer';
            $taskOpportunity->save();
        }
    
    // cria a primeira TAREFA tutorial para a nova conta registrada.
    public static function registerTasksTutorials($systemText, $user, $companyEdCustomer, $contact, $account, $contactEdCustomer) {    
            $task = new Task();
            $task->user_id = $user->id;
            $task->company_id = $companyEdCustomer->id;
            $task->name = $systemText->title;
            $task->account_id = $account->id;
            $task->contact_id = $contactEdCustomer->id;
            $task->company_id = $companyEdCustomer->id;
            $task->department = 'administrativo';
            $task->description = $systemText->text;
            $task->date_start = date('Y-m-d');
            $today = new Datetime('now');
            $today->add(new DateInterval('P1D'));
            $task->date_due = $today;
            $task->priority = 'emergência';
            $task->points = 1;
            $task->status = 'fazer';
            $task->save();
        }
        
        public static function returnTaskStages($task) {
            return Stage::where('opportunity_id', $task->opportunity_id)
//                    ->where('trash', '1=', 1)
                    ->get();
//        dd($task);
        }
}

