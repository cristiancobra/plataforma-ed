<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomainsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('domains', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_id');
			$table->foreignId('site_id');
			$table->string('name', 100);
			$table->string('holder', 100);
			$table->string('provider');
			$table->string('link_provider')->nullable();
			$table->string('provider_password')->nullable();
			$table->date('due_date');
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
		Schema::dropIfExists('domains');
	}

}
