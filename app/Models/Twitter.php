<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Twitter extends Model
{
	protected $table = 'twitters';
	protected $fillable = [
		'id', 'user_id', 'status', 'page_name','linked_facebook', 'linked_site', 'same_site_name', 'about', 'feed_content', 'value_ads', 'URL_name', 'business',
	];

	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function accounts() {
		return $this->hasMany(Account::class, 'user_id', 'id');
	}
}