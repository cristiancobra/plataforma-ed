<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use App\Models\User;

class Task extends Model {
	
	use Filterable;

	protected $table = 'tasks';
	//  The primary key associated with the table.
//	protected $primaryKey = 'id';
//	//  Indicates if the IDs are auto-incrementing.
//
//	public $incrementing = false;
//	public $timestamps = false;

	/**
	 * Tarefas do SuiteCRM, campos disponiveis (mass assignable)
	 *
	 */
	protected $fillable = [
		'id', 'user_id', 'account_id', 'date_entered', 'created_by', 'name', 'category', 'description', 'date_due', 'date_start', 'date_conclusion', 'contact_id', 'status', 'priority', 'start_time',
		'end_time', 'duration',
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

	public function user() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	private static $whiteListFilter = ['*'];
//		'id',
//		'username',
//		'family',
//		'email',
//		'count_posts',
//		'created_at',
//		'updated_at',
//	];

}
