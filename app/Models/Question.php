<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class question extends Model {

	protected $table = 'questions';
	protected $fillable = [
		'id',
		'question',
		'criterion',
		'answer1',
		'answer2',
		'answer3',
		'created_at',
		'updated_at',
	];

}
