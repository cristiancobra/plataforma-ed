<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model {

    protected $table = 'bank_accounts';
    protected $fillable = [
        'id',
        'account_id',
        'name',
        'date_creation',
        'date_closing',
        'type',
        'observations',
        'bank_id',
        'agency',
        'account_number',
        'opening_balance',
        'pix',
        'status',
    ];
    protected $hidden = [
    ];

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function bank() {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    public function transactions() {
        return $this->hasMany(Transaction::class, 'bank_account_id', 'id');
    }

    // MÉTODOS PÚBLICOS
    public static function returnTypes() {
        return $types = array(
            'conta corrente',
            'dinheiro',
            'cartão de crédito',
            'investimento',
            'poupança',
        );
    }

}
