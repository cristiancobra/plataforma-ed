<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Account;
//use App\User;

class Contact extends Model {

	protected $table = 'contacts';
	protected $fillable = [
		'id', 'account_id', 'name', 'first_name', 'last_name', 'email', 'phone', 'site', 'address', 'address _city', 'address _state', 'address _country', 'type',
	];
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}

	public function bills() {
		return $this->hasMany(Bill::class, 'id', 'contact_id');
	}
	public function contracts() {
		return $this->hasMany(Contract::class, 'id', 'contract_id');
	}
	
	public function opportunitie() {
		return $this->hasOne(Opportunitie::class, 'id', 'contact_id');
	}
	
	public function tasks() {
		return $this->hasMany(Task::class, 'id', 'contact_id');
	}
//
//	public function users() {
//		return $this->belongsToMany(User::class, 'users_accounts', 'account_id', 'user_id');
//	}

}
