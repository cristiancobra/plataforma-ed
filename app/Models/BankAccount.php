<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model {

	protected $table = 'bank_accounts';
	protected $fillable = [
		'id',
		'account_id',
		'name',
		'type',
		'observations',
		'bank_id',
		'agency',
		'account_number',
		'opening_balance',
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

}
