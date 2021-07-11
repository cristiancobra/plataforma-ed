<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use App\Models\User;

class Task extends Model {

    protected $table = 'tasks';
    protected $fillable = [
        'id',
        'user_id',
        'company_id',
        'account_id',
        'contact_id',
        'opportunity_id',
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

    static function returnDepartments() {
        return $departments = array(
            'administrativo',
            'atendimento',
            'desenvolvimento',
            'financeiro',
            'marketing',
            'produção',
            'vendas',
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
        );
    }

// retorna os módulos da plataforma quando for reportar bugs
    static function returnBugActions() {
        return $priorities = array(
            'não sei',
            'cliquei num item do menu',
            'tentei criar/salvar um registro',
            'tentei editar uma informação',
            'vi uma informação errada',
            'tentei logar/entrar na plataforma',
        );
    }

    // retorna a última tarefa feita pelo usuário logado
    public static function myLastTask() {
        return Task::latest()
                ->where('user_id', auth()->user()->id)
                ->first();
    }
}
