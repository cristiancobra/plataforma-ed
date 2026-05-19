<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->string('tracking_tag')->nullable()->after('best_ai');
            $table->string('redirect_link')->nullable()->after('image_url');
            $table->string('serial_number')->nullable()->after('model'); 
            $table->text('accessories')->nullable()->after('tracking_tag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropColumn(['tracking_tag', 'redirect_link', 'serial_number', 'accessories']);
        });
    }
};
