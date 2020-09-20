<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpotifyTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('reports', function (Blueprint $table) {
            $table->string('SP_page_name');
            $table->string('SP_URL_name');
            $table->string('SP_same_site_name');
            $table->string('SP_about');
            $table->string('SP_feed_content');
            $table->string('SP_value_ads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn([
                'TW_page_name',
                'TW_URL_name',
                'TW_same_site_name',
                'TW_about',
                'TW_feed_content',
                'TW_value_ads',
            ]);
        });
    }

}
