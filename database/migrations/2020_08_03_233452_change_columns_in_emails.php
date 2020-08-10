<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsInEmails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('emails', function (Blueprint $table) {
			$table->dropColumn('perfil_id');
			$table->tinyInteger('storage');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('emails', function (Blueprint $table) {
			$table->dropColumn('storage');
			$table->integer("perfil_id")->required();
		});
	}
}