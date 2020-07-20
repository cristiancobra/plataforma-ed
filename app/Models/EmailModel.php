<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailModel extends Model
{
	protected $table = 'emails';
	
    	protected $fillable = [
		'id', 'user_id', 'account_id', 'perfil_id', 'email', 'email_password', 'status'
	];

	public function users() {
		return $this->hasMany(App\User::class, 'user_id', 'id');
	}
}
