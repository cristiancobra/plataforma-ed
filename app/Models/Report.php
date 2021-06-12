<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AccountReport;
use App\Models\User;

class Report extends Model {

    protected $table = 'reports';
    protected $fillable = [
        'id',
        'user_id',
        'account_id',
        'name',
        'date',
        'status',
        'general',
        'target',
    ];

    // RELACIONAMENTOS
    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function accountReport() {
        return $this->hasOne(AccountReport::class, 'report_id', 'id');
    }

    public function socialmediaReports() {
        return $this->hasMany(SocialmediaReport::class, 'report_id', 'id');
    }

    public function competitorReports() {
        return $this->hasMany(CompetitorReport::class, 'report_id', 'id');
    }

    public function users() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // MÉTODOS PÚBLICO
        public static function returnStatus() {
            return $status = [
                'ativa',
                'desativada',
            ];
        }
}
