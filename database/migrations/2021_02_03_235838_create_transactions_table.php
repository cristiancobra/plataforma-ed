<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('transactions', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_id');
			$table->foreignId('bank_account_id');
			$table->foreignId('user_id');
			$table->string('type');
			$table->date('pay_day');
			$table->integer('value')->nullable();
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
		Schema::dropIfExists('transactions');
	}

}
