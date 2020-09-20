<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spotify extends Model
{
	protected $table = 'spotify';
	protected $fillable = [
		'id', 'user_id', 'status', 'page_name',  'same_site_name', 'about', 'feed_content', 'value_ads', 'URL_name',  
	];

	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function accounts() {
		return $this->hasMany(Account::class, 'user_id', 'id');
	}
}
