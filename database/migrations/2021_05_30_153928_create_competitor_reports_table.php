<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitorReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('competitor_reports', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_id');
			$table->foreignId('company_id');
			$table->foreignId('report_id');
			$table->integer('employees')->nullable();
			$table->integer('revenues')->nullable();
			$table->integer('client_number')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('competitor_reports');
	}

}
