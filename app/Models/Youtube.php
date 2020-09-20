<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Youtube extends Model

{
	protected $table = 'youtubes';
	protected $fillable = [
		'id', 'user_id', 'status', 'page_name','image_banner', 'liked_site', 'organized_playlists', 'about', 'feed_content', 'seo_content','value_ads', 'URL_name',  'feed_member', 'follow_channel', 'liked_virtualstore',  'video_banner',   'legend',  
	];

	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function accounts() {
		return $this->hasMany(Account::class, 'user_id', 'id');
	}
}
