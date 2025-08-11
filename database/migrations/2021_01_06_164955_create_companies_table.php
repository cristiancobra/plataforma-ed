<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('companies', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_id');
			$table->string('name')->nullable();
			$table->string('email')->nullable();
			$table->string('financial_email')->nullable();
			$table->string('phone')->nullable();
			$table->string('site')->nullable();
			$table->string('address')->nullable();
			$table->string('neighborhood')->nullable();
			$table->string('city')->nullable();
			$table->string('state')->nullable();
			$table->string('country')->nullable();
			$table->string('zip_code')->nullable();
			$table->string('type')->nullable();
			$table->tinyInteger('employees')->nullable();
			$table->text('observations')->nullable();
			$table->string('cnpj')->nullable();
			$table->string('instagram')->nullable();
			$table->string('facebook')->nullable();
			$table->string('linkedin')->nullable();
			$table->string('twitter')->nullable();
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
		Schema::dropIfExists('companies');
	}

}
