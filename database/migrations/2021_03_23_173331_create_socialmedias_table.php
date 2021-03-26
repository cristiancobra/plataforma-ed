<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialmediasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('socialmedias', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_id');
			$table->string('socialmedia_name');
			$table->string('name');
			$table->string('URL_name');
			$table->tinyInteger('business');
			$table->tinyInteger('linked_instagram');
			$table->tinyInteger('linked_facebook');
			$table->tinyInteger('same_site_name');
			$table->tinyInteger('about');
			$table->tinyInteger('feed_content');
			$table->tinyInteger('harmonic_feed');
			$table->tinyInteger('SEO_descriptions');
			$table->tinyInteger('feed_images');
			$table->tinyInteger('stories');
			$table->tinyInteger('interaction');
			$table->tinyInteger('igtv');
			$table->tinyInteger('reels');
			$table->tinyInteger('employee_profiles');
			$table->tinyInteger('employee_profiles_cv');
			$table->tinyInteger('offers_job');
			$table->tinyInteger('pin_content');
			$table->decimal('value_ads', 8, 2);
			$table->tinyInteger('linktree');
			$table->tinyInteger('image_banner');
			$table->tinyInteger('organized_playlists');
			$table->tinyInteger('liked_virtualstore');
			$table->tinyInteger('video_banner');
			$table->tinyInteger('legend');
			$table->tinyInteger('feed_member');
			$table->tinyInteger('follow_channel');
			$table->string('status');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('socialmedias');
	}

}
