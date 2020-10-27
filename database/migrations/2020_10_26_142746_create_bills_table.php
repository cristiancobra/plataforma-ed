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
			$table->foreignId('account_id');
			$table->foreignId('opportunitie_id');
			$table->date('date_creation');
			$table->date('pay_day');
			$table->text('description')->nullable();
			$table->string('category', 50);
			$table->string('stage', 50);
			$table->integer('price');
			$table->string('status', 50);


			$counter = 1;
			$name = "name0001";
			$amount = "amount0001";
			$hours = "hours0001";
			$cost = "cost0001";
			$tax_rate = "tax_rate0001";
			$price = "price0001";
			$margin = "margin0001";

			while ($counter < 101) {
				$table->text($name++, 50)->nullable();
				$table->integer($amount++)->nullable();
				$table->decimal($hours++, 5, 1)->nullable();
				$table->integer($cost++)->nullable();
				$table->integer($tax_rate++)->nullable();
				$table->integer($price++)->nullable();
				$table->integer($margin++)->nullable();
				$counter++;
			}

			$table->decimal('totalHours', 5, 1)->nullable();
			$table->integer('totalAmount')->nullable();
			$table->integer('totalCost')->nullable();
			$table->integer('totalTax_rate')->nullable();
			$table->integer('totalPrice')->nullable();
			$table->integer('totalMargin')->nullable();
			$table->integer('totalBalance')->nullable();

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
		Schema::dropIfExists('bills');
	}

}
