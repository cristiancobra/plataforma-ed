<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model {

    protected $table = 'stages';
    protected $fillable = [
        'id',
        'account_id',
        'user_id',
        'opportunity_id',
        'name',
        'description',
        'points',
        'start',
        'end',
        'status',
    ];
    protected $hidden = [
    ];

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function opportunity() {
        return $this->belongsTo(Opportunity::class, 'opportunity_id', 'id');
    }

    public function tasks() {
        return $this->hasMany(Task::class, 'stage_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }



// MÉTODOS PÚBLICOS

    public static function returnStatus() {
        return [
            'ativa',
            'desativada',
        ];
    }

}
