<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Linkedin extends Model
{
	protected $table = 'linkedins';
	protected $fillable = [
		'id', 'user_id', 'account_id', 'status', 'page_name', 'same_site_name', 'about', 'feed_content', 'SEO_descriptions', 'feed_images',
		'value_ads', 'URL_name', 'business', 'employee_profiles', 'offers_job',  
	];

	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}
}