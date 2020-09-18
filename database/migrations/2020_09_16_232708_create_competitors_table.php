<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('competitors', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_id');
			$table->string('name');
			$table->string('description')->nullable();
			$table->string('site');
			$table->string('site_keywords');
			$table->string('site_organic_traffic');
			$table->string('site_backlinks');
			$table->string('site_domain_score');
			$table->string('google_business');
			$table->decimal('google_business_score')->nullable();
			$table->mediumInteger('google_business_comments')->nullable();
			$table->string('ifood');
			$table->decimal('ifood_score')->nullable();
			$table->mediumInteger('ifood_comments')->nullable();
			$table->string('spotfy')->nullable();
			$table->string('city');
			$table->string('state');
			$table->string('country');
			$table->string('type');
			$table->mediumInteger('facebook_followers')->nullable();
			$table->mediumInteger('instagram_followers')->nullable();
			$table->mediumInteger('linkedin_followers')->nullable();
			$table->mediumInteger('twitter_followers')->nullable();
			$table->mediumInteger('pinterest_followers')->nullable();
			$table->mediumInteger('youtube_followers')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('competitors');
	}

}
