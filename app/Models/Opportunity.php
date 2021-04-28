<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model {

	protected $table = 'opportunities';
	protected $fillable = [
		'id',
		'account_id',
		'contact_id',
		'user_id',
		'company_id',
		'name',
		'description',
		'category',
		'stage',
		'price',
		'status',
		'date_start',
		'date_conclusion',
		'pay_day',
		'trash',
	];
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}

	public function company() {
		return $this->belongsTo(Company::class, 'company_id', 'id');
	}

	public function contact() {
		return $this->belongsTo(Contact::class, 'contact_id', 'id');
	}

	public function invoices() {
		return $this->hasMany(Invoice::class, 'id', 'opportunity_id');
	}

	public function user() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

}
