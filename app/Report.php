<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
	protected $table = 'reports';
	
    	protected $fillable = [
		'id', 'user_id', 'name', 'logomarca', 'paleta_cores', 'instagram_businness'
	];

	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
