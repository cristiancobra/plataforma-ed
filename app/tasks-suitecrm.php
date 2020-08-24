<?php

namespace App;

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
		'id', 'name', 'description', 'status', 'priority', 'assigned_user_id', 'Deleted'
	];

	/**
	 * Tarefas do SuiteCRM, campos NAO disponiveis (mass assignable)
	 */
	protected $hidden = [
	];

	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

}
