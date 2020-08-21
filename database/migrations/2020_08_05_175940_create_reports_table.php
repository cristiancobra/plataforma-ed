<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('reports', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained();
			$table->string('name');
			$table->string('date');
			$table->string('status');
			$table->string('logo');
			$table->string('palette');
			$table->string('FB_page_name');
			$table->string('FB_URL_name');
			$table->string('FB_business');
			$table->string('FB_linked_instagram');
			$table->string('FB_same_site_name');
			$table->string('FB_about');
			$table->string('FB_feed_content');
			$table->string('FB_harmonic_feed');
			$table->string('FB_SEO_descriptions');
			$table->string('FB_feed_images');
			$table->string('FB_stories');
			$table->string('FB_interaction');
			$table->string('FB_value_ads');

			$table->string('IG_page_name');
			$table->string('IG_URL_name');
			$table->string('IG_business');
			$table->string('IG_linked_facebook');
			$table->string('IG_same_site_name');
			$table->string('IG_about');
			$table->string('IG_feed_content');
			$table->string('IG_harmonic_feed');
			$table->string('IG_SEO_descriptions');
			$table->string('IG_feed_images');
			$table->string('IG_stories');
			$table->string('IG_interaction');
			$table->string('IG_value_ads');
			$table->string('IG_linktree');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('reports');
	}

}
