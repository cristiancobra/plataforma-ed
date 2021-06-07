<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountReports extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('account_reports', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_id');
			$table->foreignId('report_id');
			$table->tinyInteger('logo');
			$table->tinyInteger('pallet');
			$table->tinyInteger('CNPJ');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('account_reports');
	}

}
