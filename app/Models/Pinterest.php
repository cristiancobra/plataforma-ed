<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Pinterest extends Model
{
 
	protected $table = 'pinterests';
	protected $fillable = [
		'id', 'user_id', 'status', 'page_name', 'same_site_name', 'about', 'pin_content', 'value_ads', 'URL_name', 'business',  'number_followers', 'number_location', 'age_rage',  'gender',   'most-pin', 
	];

	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function accounts() {
		return $this->hasMany(Account::class, 'user_id', 'id');
	}
}