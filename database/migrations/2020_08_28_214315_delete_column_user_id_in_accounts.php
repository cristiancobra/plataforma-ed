<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteColumnUserIdInAccounts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('accounts', function (Blueprint $table) {
			// SQLite (usado nos testes) não suporta dropar uma foreign key isoladamente; o
			// dropColumn() abaixo já recria a tabela sem a coluna (e sem a constraint) nesse driver.
			if (Schema::getConnection()->getDriverName() !== 'sqlite') {
				$table->dropForeign(['user_id']);
			}
			$table->dropColumn(['user_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('accounts', function (Blueprint $table) {
			$table->foreignId('user_id')->constrained;
		});
	}

}
