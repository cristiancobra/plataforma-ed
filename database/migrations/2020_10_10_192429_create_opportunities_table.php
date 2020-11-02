<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpportunitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('opportunities', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_id');
			$table->foreignId('contact_id');
			$table->foreignId('product_id');
			$table->string('name', 100);
			$table->date('date_start')->nullable();
			$table->date('date_conclusion')->nullable();
			$table->date('pay_day')->nullable();
			$table->text('description')->nullable();
			$table->string('category', 50);
			$table->string('stage', 50);
			$table->integer('price')->nullable();
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
		Schema::dropIfExists('opportunities');
	}

}
