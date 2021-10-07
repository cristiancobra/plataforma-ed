<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStrengthsImageIdColumnsInPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
                        $table->foreignId('strength1_image_id')->nullable();
                        $table->foreignId('strength2_image_id')->nullable();
                        $table->foreignId('strength3_image_id')->nullable();
                        $table->foreignId('strength4_image_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
                        $table->dropColumn('strength1_image_id');
                        $table->dropColumn('strength2_image_id');
                        $table->dropColumn('strength3_image_id');
                        $table->dropColumn('strength4_image_id');
        });
    }
}
