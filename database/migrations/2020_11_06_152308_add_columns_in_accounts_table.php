<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('accounts', function (Blueprint $table) {
			$table->string('cnpj', 14)->nullable();
			$table->integer('revenues')->nullable();
			$table->string('logo')->nullable();
			$table->string('principal_color')->nullable();
			$table->string('complementary_color')->nullable();
			$table->string('opposite_color')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('accounts', function (Blueprint $table) {
			$table->dropColumn('cnpj');
			$table->dropColumn('revenues');
			$table->dropColumn('logo');
			$table->dropColumn('principal_color');
			$table->dropColumn('complementary_color');
			$table->dropColumn('opposite_color');
		});
	}
}