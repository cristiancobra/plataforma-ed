<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwittersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('twitters', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained();
			$table->string('page_name');
			$table->string('URL_name');
			$table->string('status');
			$table->string('business');
			$table->string('linked_facebook');
			$table->string('linked_site');
			$table->string('same_site_name');
			$table->string('about');
			$table->string('feed_content');
			$table->string('value_ads');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('twitters');
	}

}
