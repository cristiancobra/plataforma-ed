<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('contacts', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_id');
			$table->string('name');
			$table->string('first_name');
			$table->string('last_name')->nullable();
			$table->string('email')->nullable();
			$table->string('phone')->nullable();
			$table->string('site')->nullable();
			$table->string('address')->nullable();
			$table->string('city')->nullable();
			$table->string('state')->nullable();
			$table->string('country')->nullable();
			$table->string('type')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('contacts');
	}

}
