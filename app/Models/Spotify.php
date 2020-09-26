<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Account;
use App\User;

class Spotify extends Model
{
	protected $table = 'spotifys';
	protected $fillable = [
		'id', 'user_id', 'account_id', 'status', 'page_name',  'same_site_name', 'about', 'feed_content', 'value_ads', 'URL_name',  'business'
	];

	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}
}
