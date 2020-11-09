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
			$table->foreignId('account_id')->constrained();
			$table->string('name');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email')->nullable();
			$table->string('phone')->nullable();
			$table->string('site')->nullable();
			$table->string('address')->nullable();
			$table->string('address_city')->nullable();
			$table->string('address_state')->nullable();
			$table->string('address_country')->nullable();
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
