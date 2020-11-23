<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journey extends Model
{
	protected $table = 'journeys';

	protected $fillable = [
		'id', 'account_id', 'task_id', 'user_id',  'date', 'description', 'status', 'start_time', 'end_time', 'duration', 
	];

	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}

	public function contact() {
		return $this->belongsTo(Contact::class, 'contact_id', 'id');
	}

	public function task() {
		return $this->belongsTo(Task::class, 'task_id', 'id');
	}
	
	public function user() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

}
