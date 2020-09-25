<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Account;
use App\User;

class Instagram extends Model
{
	protected $table = 'instagrams';
	protected $fillable = [
		'id', 'user_id', 'account_id', 'status', 'page_name', 'linked_facebook', 'same_site_name', 'about', 'feed_content', 'harmonic_feed', 'SEO_description', 'feed_images',
		'stories', 'interaction', 'value_ads', 'URL_name', 'business', 'linktree',
	];

	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}

}
