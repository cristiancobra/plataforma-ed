<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Account;
use App\User;

class Pinterest extends Model
{
 
	protected $table = 'pinterests';
	protected $fillable = [
		'id', 'user_id', 'account_id', 'status', 'page_name', 'linked_site', 'same_site_name', 'about', 'pin_content', 'value_ads', 'URL_name', 'business',  'number_followers', 'number_location', 'age_rage',  'gender',   'most-pin', 
	];

	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}
}