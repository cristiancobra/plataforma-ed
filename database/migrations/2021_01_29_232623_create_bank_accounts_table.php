<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('bank_accounts', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_id');
			$table->string('name');
			$table->string('type')->nullable();
			$table->string('observations')->nullable();
			$table->string('bank_id')->nullable();
			$table->string('agency')->nullable();
			$table->string('account_number')->nullable();
			$table->decimal('opening_balance', 8,2);
			$table->string('status'); 
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('bank_accounts');
	}

}
