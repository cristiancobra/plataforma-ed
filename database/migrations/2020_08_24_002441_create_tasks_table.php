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
			$table->foreignId('user_id')->constrained();
			$table->string('name');
			$table->string('category');
			$table->date('date_entered');
			$table->string('created_by');
			$table->string('description');
			$table->date('date_due');
			$table->date('date_start');
			$table->string('contact_id');
			$table->string('status');
			$table->string('priority');
			$table->string('start_time');
			$table->string('end_time');
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
