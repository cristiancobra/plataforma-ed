<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Domain;

class Site extends Model
{
  protected $table = 'sites';
	protected $fillable = [
		'id', 'account_id', 'name', 'link_view', 'link_edit', 'site_password', 'hosting', 'link_hosting', 'hosting_password',
		'creation_date', 'status',
	];
	
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}
	
	public function domains() {
		return $this->hasMany(Domain::class, 'site_id', 'id');
	}
}
