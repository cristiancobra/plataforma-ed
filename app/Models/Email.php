<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Email extends Model
{
	protected $table = 'emails';
	
    	protected $fillable = [
		'id', 'user_id', 'account_id', 'storage', 'email', 'email_password', 'status'
	];
	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}
	public function user() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
