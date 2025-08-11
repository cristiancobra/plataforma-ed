<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractTemplate extends Model
{
  protected $table = 'contracts_templates';
	protected $fillable = [
		'id',
		'account_id',
		'name',
		'text',
	];
	
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}
}