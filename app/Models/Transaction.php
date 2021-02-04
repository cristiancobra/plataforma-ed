<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {

	protected $table = 'transactions';
	protected $fillable = [
		'id',
		'user_id',
		'account_id',
		'contact_id',
		'bank_account_id',
		'type',
		'pay_day',
		'value',
		'observations',
		'status',
	];
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}

}
