<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Email extends Model
{
	protected $table = 'emails';
	
    	protected $fillable = [
		'id', 'user_id', 'account_id', 'storage', 'email', 'email_password', 'status'
	];

	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
