<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use App\Models\User;

class Task extends Model {

	protected $table = 'tasks';

	protected $fillable = [
		'id', 'user_id', 'account_id', 'date_entered', 'created_by', 'name', 'department', 'description', 'date_due', 'date_start',
		'date_conclusion', 'contact_id', 'status', 'priority', 'start_time', 'end_time', 'duration',
	];

	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}

	public function contact() {
		return $this->belongsTo(Contact::class, 'contact_id', 'id');
	}
	
	public function journeys() {
		return $this->hasMany(Journey::class, 'id', 'task_id');
	}

	public function user() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
