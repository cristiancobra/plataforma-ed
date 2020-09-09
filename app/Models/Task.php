<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Task extends Model {

	protected $table = 'tasks';
	//  The primary key associated with the table.
	protected $primaryKey = 'id';
	//  Indicates if the IDs are auto-incrementing.

	public $incrementing = false;
	public $timestamps = false;

	/**
	 * Tarefas do SuiteCRM, campos disponiveis (mass assignable)
	 *
	 */
	protected $fillable = [
		'id', 'user_id', 'date_entered', 'created_by', 'name', 'category', 'description', 'responsible_id', 'date_due', 'date_start', 'contact_id', 'status', 'priority', 'start_time', 
		'end_time', 'duration', 'account_id',
	];

	/**
	 * Tarefas do SuiteCRM, campos NAO disponiveis (mass assignable)
	 */
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}

	public function contact() {
		return $this->belongsTo(Contact::class, 'contact_id', 'id');
	}
	
	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
