<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('bills', function (Blueprint $table) {
			$table->id();
			$table->foreignId('opportunitie_id');
			$table->foreignId('account_id');
			$table->foreignId('contact_id');
			$table->foreignId('product_id');
			$table->date('date_creation');
			$table->date('pay_day');
			$table->text('description')->nullable();
			$table->string('category', 50);
			$table->string('stage', 50);
			$table->integer('price');
			$table->string('status', 50);
			$table->string('invoice');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('bill_');
	}

}
