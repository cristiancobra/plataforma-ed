<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkedinsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('linkedins', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id');
			$table->string('page_name');
			$table->string('URL_name');
			$table->string('status');
			$table->string('business');
			$table->string('same_site_name');
			$table->string('about');
			$table->string('feed_content');
			$table->string('SEO_descriptions');
			$table->string('feed_images');
			$table->string('value_ads');
			$table->string('employee_profiles');
			$table->string('offers_job');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('linkedins');
	}

}
