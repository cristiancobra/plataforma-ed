<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInContractsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('contracts', function (Blueprint $table) {
			$table->foreignId('user_id');
			$table->foreignId('company_id');
			$table->text('text');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('contracts', function (Blueprint $table) {
			$table->dropColumn('user_id');
			$table->dropColumn('company_id');
			$table->dropColumn('text');
		});
	}

}
