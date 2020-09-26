<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Account;
use App\User;

class Youtube extends Model

{
	protected $table = 'youtubes';
	protected $fillable = [
		'id', 'user_id', 'account_id', 'status', 'page_name','image_banner', 'linked_site', 'organized_playlists', 'about', 'feed_content', 'seo_content','value_ads', 'URL_name',
		'feed_member', 'follow_channel', 'liked_virtualstore',  'video_banner',   'legend',  
	];

	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}
}
