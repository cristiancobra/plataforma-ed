<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BankAccount;

class Transaction extends Model {

	protected $table = 'transactions';
	protected $fillable = [
		'id',
		'user_id',
		'company_id',
		'account_id',
		'contact_id',
		'invoice_id',
		'bank_account_id',
		'type',
		'pay_day',
		'value',
		'observations',
		'payment_method',
		'status',
	];
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}
	public function bankAccount() {
		return $this->belongsTo(BankAccount::class, 'bank_account_id', 'id');
	}
                	public function company() {
		return $this->belongsTo(Company::class, 'company_id', 'id');
	}
	public function invoice() {
		return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
	}
	public function user() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
