<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompetitiveAdvantageColumnInAccountsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('accounts', function (Blueprint $table) {
            $table->string('competitive_advantage')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('competitive_advantage');
        });
    }

}
