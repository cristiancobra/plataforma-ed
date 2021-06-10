<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('contact_reports', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_id');
			$table->foreignId('report_id');
			$table->integer('lead_source_')->nullable();
			$table->integer('male_13_17')->nullable();
			$table->integer('male_18_24')->nullable();
			$table->integer('male_25_34')->nullable();
			$table->integer('male_35_44')->nullable();
			$table->integer('male_45_54')->nullable();
			$table->integer('male_55_65')->nullable();
			$table->integer('male_65')->nullable();
			$table->integer('female_13_17')->nullable();
			$table->integer('female_18_24')->nullable();
			$table->integer('female_25_34')->nullable();
			$table->integer('female_35_44')->nullable();
			$table->integer('female_45_54')->nullable();
			$table->integer('female_55_65')->nullable();
			$table->integer('profession')->nullable();
			$table->integer('job_position')->nullable();
			$table->integer('school')->nullable();
			$table->integer('city')->nullable();
			$table->integer('country')->nullable();
			$table->integer('civil_status')->nullable();
			$table->integer('naturality')->nullable();
			$table->integer('kids')->nullable();
			$table->integer('hobby')->nullable();
			$table->decimal('income', 8, 2)->nullable();
			$table->integer('religion')->nullable();
			$table->integer('eitinicity')->nullable();
			$table->integer('gender')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('contact_reports');
	}

}
