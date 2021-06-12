<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('questions', function (Blueprint $table) {
			$table->id();
			$table->string('question');
			$table->string('criterion');
			$table->text('answer1')->nullable();
			$table->text('answer2')->nullable();
			$table->text('answer3')->nullable();
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
		Schema::dropIfExists('questions');
	}

}
