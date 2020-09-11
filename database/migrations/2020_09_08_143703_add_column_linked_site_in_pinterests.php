<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnLinkedSiteInPinterests extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('pinterests', function (Blueprint $table) {
            $table->string('linked_site');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('pinterests', function (Blueprint $table) {
     $table->dropColumn('linked_site');
        });
    }

}
