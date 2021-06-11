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

}
