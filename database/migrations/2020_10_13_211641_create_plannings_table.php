<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanningsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('plannings', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_id');
			$table->string('name');
			$table->integer('months');
			$table->integer('expenses')->nullable();

			$counter = 1;
			$name = "name0001";
			$amount = "amount0001";
			$hours = "hours0001";
			$cost = "cost0001";
			$tax_rate = "tax_rate0001";
			$price = "price0001";

			while ($counter < 101) {
			$table->text($name++, 50)->nullable();
			$table->integer($amount++)->nullable();
			$table->decimal($hours++, 5, 1)->nullable();
			$table->integer($cost++)->nullable();
			$table->integer($tax_rate++)->nullable();
			$table->integer($price++)->nullable();
			$counter++;
			}
			
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
		Schema::dropIfExists('plannings');
	}

}
