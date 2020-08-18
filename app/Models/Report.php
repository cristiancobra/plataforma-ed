<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model {

	protected $table = 'reports';
	protected $fillable = [
		'id', 'user_id', 'name', 'date', 'status', 'logo', 'palette', 'FB_page_name', 'FB_URL_name', 'FB_business', 'FB_linked_instagram', 'FB_same_site_name', 'FB_about',
		'FB_feed_content', 'FB_harmonic_feed', 'FB_SEO_descriptions', 'FB_feed_images', 'FB_stories', 'FB_interaction', 'FB_value_ads',
	];

//'IG_page_name',
// $table->string('IG_URL_name');
//$table->string('IG_business');
//$table->string('IG_linked_facebook');
//$table->string('IG_same_site_name');
//$table->string('IG_about');
//$table->string('IG_feed_content');
//$table->string('IG_harmonic_feed');
//$table->string('IG_SEO_descriptions');
//$table->string('IG_feed_images');
//$table->string('IG_stories');
//$table->string('IG_interaction');
//$table->string('IG_pay_ads');
//$table->string('IG_value_ads');
//$table->string('IG_linktree');


	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

}
