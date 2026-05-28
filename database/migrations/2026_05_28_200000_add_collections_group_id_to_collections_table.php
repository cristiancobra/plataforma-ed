<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->unsignedBigInteger('collections_group_id')->nullable()->after('contact_id');
            $table->foreign('collections_group_id')
                ->references('id')
                ->on('collections_group')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropForeign(['collections_group_id']);
            $table->dropColumn('collections_group_id');
        });
    }
};
