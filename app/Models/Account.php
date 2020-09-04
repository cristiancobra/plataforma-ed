<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Account extends Model {

	protected $table = 'accounts';
	protected $fillable = [
		'id', 'user_id', 'name', 'email', 'phone', 'site', 'address', 'address _city', 'address _state', 'address _country', 'type', 'employees', 'status',
		];

	public function users() {
		return $this->belongsToMany(User::class, 'users_accounts',  'account_id', 'user_id');
	}
	
		public function contacts() {
		return $this->hasMany(Contact::class, 'id', 'account_id');
	}
}
