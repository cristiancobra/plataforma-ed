<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('attachments', function (Blueprint $table) {
            $table->unsignedBigInteger('opportunity_id')->nullable()->after('collection_id');
            $table->foreign('opportunity_id')->references('id')->on('opportunities')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('attachments', function (Blueprint $table) {
            $table->dropForeign(['opportunity_id']);
            $table->dropColumn('opportunity_id');
        });
    }
};
