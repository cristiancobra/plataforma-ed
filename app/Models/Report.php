<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Report extends Model {

	protected $table = 'reports';
	protected $fillable = [
		'id', 'user_id', 'account_id', 'name', 'date', 'status', 'general', 'logo', 'palette',
		'FB_page_name', 'FB_URL_name', 'FB_business', 'FB_linked_instagram', 'FB_same_site_name', 'FB_about',
		'FB_feed_content', 'FB_harmonic_feed', 'FB_SEO_descriptions', 'FB_feed_images', 'FB_stories', 'FB_interaction', 'FB_value_ads',
		
		'TW_page_name', 'TW_URL_name', 'TW_business', 'TW_linked_facebook', 'TW_linked_site', 'TW_same_site_name', 'TW_about', 'TW_feed_content', 'TW_value_ads',
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}

	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

}
