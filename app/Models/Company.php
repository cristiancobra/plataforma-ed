<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {

	protected $table = 'companies';
	protected $fillable = [
		'id',
		'account_id',
		'name',
		'email',
		'financial_email',
		'phone',
		'site',
		'address',
		'neighborhood',
		'city',
		'state',
		'country',
		'zip_code',
		'type',
		'employees',
		'observations',
		'cnpj',
		'instagram',
		'facebook',
		'linkedin',
		'twitter',
		'status',
	];
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}
	public function contacts() {
		return $this->belongsToMany(Contact::class);
	}
//	public function contracts() {
//		return $this->hasMany(Contract::class, 'id', 'contract_id');
//	}	
//	public function opportunities() {
//		return $this->hasMany(Opportunity::class, 'contact_id', 'id');
//	}
//	public function tasks() {
//		return $this->hasMany(Task::class, 'id', 'contact_id');
//	}
//	public function user() {
//		return $this->belongsTo(Models\User::class, 'id', 'contact_id');
//	}
//
//	public function users() {
//		return $this->belongsToMany(User::class, 'users_accounts', 'account_id', 'user_id');
//	}
}
