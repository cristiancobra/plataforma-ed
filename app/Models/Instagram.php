<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Instagram extends Model
{
	protected $table = 'instagrams';
	protected $fillable = [
		'id', 'user_id', 'name', 'status', 'page_name', 'linked_instagram', 'same_site_name', 'about', 'feed_content', 'harmonic_feed', 'SEO_descriptions', 'feed_images',
		'stories', 'interaction', 'value_ads', 'URL_name', 'business', 'linktree'
	];

	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function accounts() {
		return $this->hasMany(Account::class, 'user_id', 'id');
	}

}
