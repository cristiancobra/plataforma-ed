<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Facebook extends Model {

	protected $table = 'facebooks';
	protected $fillable = [
		'id', 'user_id', 'status', 'page_name', 'linked_instagram', 'same_site_name', 'about', 'feed_content', 'harmonic_feed', 'SEO_descriptions', 'feed_images',
		'stories', 'interaction', 'value_ads', 'URL_name', 'business' , 'number_followers', 'number_location', 'age_rage',  'gender',   'most-like', 
	];

	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function accounts() {
		return $this->hasMany(Account::class, 'user_id', 'id');
	}

}
