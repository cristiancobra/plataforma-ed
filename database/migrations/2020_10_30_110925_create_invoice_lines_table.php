<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceLinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('invoice_lines', function (Blueprint $table) {
			$table->id();
			$table->foreignId('invoice_id');
			$table->foreignId('product_id');
			$table->integer('amount');
			$table->decimal('subtotalHours', 5, 1);
			$table->integer('subtotalCost');
			$table->integer('subtotalTax_rate');
			$table->integer('subtotalPrice');
			$table->integer('subtotalMargin');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('invoice_lines');
	}

}
