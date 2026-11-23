<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Campo geral: aparece em todos os tipos de acervo (inclusive os criados depois), sem vínculo N:N.
     */
    public function up()
    {
        Schema::table('collection_fields', function (Blueprint $table) {
            $table->boolean('is_global')->default(false)->after('required');
        });
    }

    public function down()
    {
        Schema::table('collection_fields', function (Blueprint $table) {
            $table->dropColumn('is_global');
        });
    }
};
