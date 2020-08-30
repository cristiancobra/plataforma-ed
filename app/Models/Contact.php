<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Account;
use App\User;

class Contact extends Model {

	protected $table = 'contacts';
	protected $fillable = [
		'id', 'user_id', 'name', 'first_name', 'last_name', 'email', 'phone', 'site', 'address', 'address _city', 'address _state', 'address _country', 'type',
	];
	protected $hidden = [
	];

	public function users() {
		return $this->belongsToMany(User::class, 'users_accounts', 'account_id', 'user_id');
	}

	public function accounts() {
		return $this->hasOne(Account::class, 'account_id', 'id');
	}

}
