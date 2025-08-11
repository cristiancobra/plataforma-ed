<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrashColumnInJourneysTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('journeys', function (Blueprint $table) {
            $table->tinyInteger('trash')->before('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('journeys', function (Blueprint $table) {
            $table->dropColumn('trash');
        });
    }

}
