<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('invoices', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_id');
			$table->foreignId('opportunity_id')->nullable();
			$table->foreignId('user_id');
			$table->date('date_creation');
			$table->date('pay_day');
			$table->text('description')->nullable();
			$table->integer('discount')->nullable();
			$table->integer('subtotal');

			$table->decimal('totalHours', 5, 1)->nullable();
			$table->integer('totalAmount')->nullable();
			$table->integer('totalCost')->nullable();
			$table->integer('totalTax_rate')->nullable();
			$table->integer('totalPrice')->nullable();
			$table->integer('totalMargin')->nullable();
			$table->integer('totalBalance')->nullable();

			$table->string('receipt')->nullable();
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
		Schema::dropIfExists('invoices');
	}

}
