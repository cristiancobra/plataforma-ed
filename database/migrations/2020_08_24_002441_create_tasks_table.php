<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('tasks', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id');
			$table->string('name');
			$table->string('department');
			$table->date('date_entered');
			$table->string('created_by');
			$table->text('description');
			$table->date('date_due');
			$table->date('date_start');
			$table->string('contact_id')->nullable();
			$table->string('status');
			$table->string('priority');
			$table->time('start_time', 0)->nullable();
			$table->time('end_time', 0)->nullable();
			$table->integer('duration')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('tasks');
	}

}
