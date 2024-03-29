<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialmediaReport extends Model {

	protected $table = 'socialmedia_reports';
	protected $fillable = [
		'id',
		'account_id',
		'socialmedia_id',
		'report_id',
		'bussiness',
		'linked_intagram',
		'linked_facebook',
		'same_site_name',
		'about',
		'feed_content',
		'harmonic_feed',
		'feed_content',
		'SEO_descriptions',
		'feed_images',
		'stories',
		'interaction',
		'igtv',
		'reels',
		'employee_profiles',
		'employee_profiles_cv',
		'offers_job',
		'pin_content',
		'value_ads',
		'linktree',
		'image_banner',
		'organized_playlists',
		'liked_virtualstore',
		'video_banner',
		'legend',
		'feed_member',
		'follow_channel',
		'followers',
		'keyword_1',
		'keyword_2',
		'keyword_3',
		'keyword_4',
		'keyword_5',
		'male_13_17',
		'male_18_24',
		'male_25_34',
		'male_35_44',
		'male_45_54',
		'male_55_65',
		'male_65',
		'female_13_17',
		'female_18_24',
		'female_25_34',
		'female_35_44',
		'female_45_54',
		'female_55_65',
		'female_65',
		'city_followers_1',
		'number_city_followers_1',
		'city_followers_2',
		'number_city_followers_2',
		'city_followers_3',
		'number_city_followers_3',
		'observation',
		'type',
		'status',
	];
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}
	public function report() {
		return $this->belongsTo(Report::class, 'id', 'report_id');
	}
	public function socialmedia() {
		return $this->belongsTo(Socialmedia::class,  'socialmedia_id', 'id');
	}

}
