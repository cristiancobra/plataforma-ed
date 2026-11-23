<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Situação cadastral do fornecedor no CADIN estadual e federal.
     * Valores: em_dia / devedor (null = não consultado).
     */
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('cadin_estadual', 20)->nullable()->after('status');
            $table->string('cadin_federal', 20)->nullable()->after('cadin_estadual');
            $table->date('cadin_checked_at')->nullable()->after('cadin_federal');
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['cadin_estadual', 'cadin_federal', 'cadin_checked_at']);
        });
    }
};
