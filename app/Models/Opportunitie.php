<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opportunitie extends Model
{
  protected $table = 'opportunities';
	protected $fillable = [
		'id', 'account_id', 'contact_id',  'name', 'description', 'category',  'stage',  'price', 'status', 'date_start', 'date_conclusion', 'pay_day',
	];
	
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}
}