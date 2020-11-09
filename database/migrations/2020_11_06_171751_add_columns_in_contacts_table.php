<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('contacts', function (Blueprint $table) {
			$table->string('company')->nullable();
			$table->string('cpf')->nullable();
			$table->string('neighborhood')->nullable();
			$table->string('job_position')->nullable();
			$table->string('acess_profile')->nullable();
			$table->date('date_birth')->nullable();
			$table->string('profession')->nullable();
			$table->string('religion')->nullable();
			$table->string('etinicity')->nullable();
			$table->string('naturality')->nullable();
			$table->string('sexual_orientation')->nullable();
			$table->string('schollarity')->nullable();
			$table->string('income')->nullable();
			$table->string('civil_state')->nullable();
			$table->integer('kids')->nullable();
			$table->string('hobbie')->nullable();
			$table->string('instagram')->nullable();
			$table->string('facebook')->nullable();
			$table->string('linkedin')->nullable();
			$table->string('twitter')->nullable();
			$table->string('lead_source')->nullable();
		});
	}

	public function down() {
		Schema::table('accounts', function (Blueprint $table) {
			$table->dropColumn('company');
			$table->dropColumn('cpf');
			$table->dropColumn('neighborhood');
			$table->dropColumn('job_position');
			$table->dropColumn('acess_profile');
			$table->dropColumn('date_birth');
			$table->dropColumn('profession');
			$table->dropColumn('religion');
			$table->dropColumn('etinicity');
			$table->dropColumn('naturality');
			$table->dropColumn('sexual_orientation');
			$table->dropColumn('schollarity');
			$table->dropColumn('income');
			$table->dropColumn('civil_state');
			$table->dropColumn('kids');
			$table->dropColumn('hobbie');
			$table->dropColumn('instagram');
			$table->dropColumn('facebook');
			$table->dropColumn('linkedin');
			$table->dropColumn('twitter');
			$table->dropColumn('lead_source');
		});
	}

}
