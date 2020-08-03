<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class AccountModel extends Model {

	protected $table = 'accounts';
	protected $fillable = [
		'id', 'user_id', 'name', 'email', 'phone', 'site', 'address', 'address _city', 'address _state', 'address _country', 'type', 'employees'
		];

	public function users() {
		return $this->belongsToMany(User::class, 'users_accounts',  'account_id', 'user_id');
	}
}
