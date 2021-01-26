<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('contracts', function (Blueprint $table) {
			$table->id();
			$table->string('name', 100);
			$table->foreignId('account_id');
			$table->foreignId('contact_id');
			$table->foreignId('opportunity_id');
			$table->foreignId('product_id');
			$table->string('witness1', 100);
			$table->string('witness2', 100);
			$table->text('observations')->nullable();
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
		Schema::dropIfExists('contracts');
	}

}
