<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planning extends Model {

    protected $table = 'plannings';
    protected $fillable = [
        'id',
        'account_id',
        'name',
        'expenses',
        'months',
        'date_creation',
        'observations',
        'growth_rate',
        'increased_expenses',
        'total_hours',
        'total_amount',
        'total_cost',
        'total_tax_rate',
        'total_price',
        'total_margin',
        'total_balance',
        'type',
        'status',
    ];
    protected $hidden = [
    ];

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

}
