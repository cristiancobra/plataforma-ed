<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Site;

class Domain extends Model
{
  protected $table = 'domains';
	protected $fillable = [
		'id', 'account_id', 'site_id', 'name', 'holder', 'provider', 'link_provider', 'provider_password', 'due_date',
	];

	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}
	
	public function domains() {
		return $this->belongsTo(Site::class, 'site_id', 'id');
	}
}
