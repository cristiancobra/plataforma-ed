<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Account;
use App\User;

class Pinterest extends Model
{
 
	protected $table = 'pinterests';
	protected $fillable = [
		'id', 'user_id', 'account_id', 'status', 'page_name', 'URL_name', 'same_site_name', 'about', 'pin_content', 'value_ads', 'business',
	];

	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}
}