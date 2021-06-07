<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialmediaReports extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('socialmedia_reports', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_id');
			$table->foreignId('socialmedia_id');
			$table->foreignId('report_id');
			$table->tinyInteger('business')->nullable();
			$table->tinyInteger('linked_instagram')->nullable();
			$table->tinyInteger('linked_facebook')->nullable();
			$table->tinyInteger('same_site_name')->nullable();
			$table->tinyInteger('about')->nullable();
			$table->tinyInteger('feed_content')->nullable();
			$table->tinyInteger('harmonic_feed')->nullable();
			$table->tinyInteger('SEO_descriptions')->nullable();
			$table->tinyInteger('feed_images')->nullable();
			$table->tinyInteger('stories')->nullable();
			$table->tinyInteger('interaction')->nullable();
			$table->tinyInteger('igtv')->nullable();
			$table->tinyInteger('reels')->nullable();
			$table->tinyInteger('employee_profiles')->nullable();
			$table->tinyInteger('employee_profiles_cv')->nullable();
			$table->tinyInteger('offers_job')->nullable();
			$table->tinyInteger('pin_content')->nullable();
			$table->decimal('value_ads', 8, 2)->nullable();
			$table->tinyInteger('linktree')->nullable();
			$table->tinyInteger('image_banner')->nullable();
			$table->tinyInteger('organized_playlists')->nullable();
			$table->tinyInteger('liked_virtualstore')->nullable();
			$table->tinyInteger('video_banner')->nullable();
			$table->tinyInteger('legend')->nullable();
			$table->tinyInteger('feed_member')->nullable();
			$table->tinyInteger('follow_channel')->nullable();
			$table->integer('followers');
			$table->integer('male_13_17');
			$table->integer('male_18_24');
			$table->integer('male_25_34');
			$table->integer('male_35_44');
			$table->integer('male_45_54');
			$table->integer('male_55_65');
			$table->integer('male_65');
			$table->integer('female_13_17');
			$table->integer('female_18_24');
			$table->integer('female_25_34');
			$table->integer('female_35_44');
			$table->integer('female_45_54');
			$table->integer('female_55_65');
			$table->integer('female_65');
			$table->string('city_followers_1');
			$table->integer('number_city_followers_1');
			$table->string('city_followers_2');
			$table->integer('number_city_followers_2');
			$table->string('city_followers_3');
			$table->integer('number_city_followers_3');
			$table->string('observation')->nullable();
			$table->string('keyword_1')->nullable();
			$table->string('keyword_2')->nullable();
			$table->string('keyword_3')->nullable();
			$table->string('keyword_4')->nullable();
			$table->string('keyword_5')->nullable();
			$table->string('type');
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
		Schema::dropIfExists('socialmedia_reports');
	}

}
