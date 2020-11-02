<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('sites', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_id');
			$table->string('name', 100);
			$table->string('link_view');
			$table->string('link_edit');
			$table->string('site_password')->nullable();
			$table->string('hosting');
			$table->string('link_hosting')->nullable();
			$table->string('hosting_password')->nullable();
			$table->date('creation_date')->nullable();
			$table->string('status', 50);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('sites');
	}

}
