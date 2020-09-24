<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Account;
use App\User;

class Twitter extends Model
{
	protected $table = 'twitters';
	protected $fillable = [
		'id', 'user_id', 'status', 'page_name','linked_facebook', 'linked_site', 'same_site_name', 'about', 'feed_content', 'value_ads', 'URL_name', 'business',  'number_followers', 'number_location', 'age_rage',  'gender',   'most-like',  
	];

	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}
}