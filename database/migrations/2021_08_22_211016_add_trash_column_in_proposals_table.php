<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrashColumnInProposalsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('proposals', function (Blueprint $table) {
            $table->tinyInteger('trash');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn('trash');
        });
    }

}
