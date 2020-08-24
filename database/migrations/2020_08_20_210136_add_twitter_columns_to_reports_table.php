<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTwitterColumnsToReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('reports', function (Blueprint $table) {
			$table->string('TW_page_name');
			$table->string('TW_URL_name');
			$table->string('TW_business');
			$table->string('TW_linked_facebook');
			$table->string('TW_linked_site');
			$table->string('TW_same_site_name');
			$table->string('TW_about');
			$table->string('TW_feed_content');
			$table->string('TW_value_ads');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('reports', function (Blueprint $table) {
			$table->dropColumn([
				'TW_page_name',
				'TW_URL_name',
				'TW_business',
				'TW_linked_facebook',
				'TW_linked_site',
				'TW_same_site_name',
				'TW_about',
				'TW_feed_content',
				'TW_value_ads',
			]);
		});
	}

}
