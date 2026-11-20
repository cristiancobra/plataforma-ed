<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Os campos personalizados passam a ser associados aos tipos de acervo (N:N): o tipo escolhe
     * quais campos tem, e um mesmo campo pode ser reaproveitado em vários tipos.
     */
    public function up()
    {
        Schema::create('collection_field_type', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_field_id')->constrained('collection_fields')->cascadeOnDelete();
            $table->foreignId('collection_type_id')->constrained('collection_types')->cascadeOnDelete();
            $table->unique(['collection_field_id', 'collection_type_id'], 'collection_field_type_unique');
        });

        // campos de um tipo continuam nele; campos "de todos os tipos" vão para todos os tipos da conta
        foreach (DB::table('collection_fields')->get() as $field) {
            $typeIds = $field->collection_type_id
                ? [$field->collection_type_id]
                : DB::table('collection_types')->where('account_id', $field->account_id)->pluck('id')->all();

            foreach ($typeIds as $typeId) {
                DB::table('collection_field_type')->insert([
                    'collection_field_id' => $field->id,
                    'collection_type_id' => $typeId,
                ]);
            }
        }

        Schema::table('collection_fields', function (Blueprint $table) {
            $table->dropForeign(['collection_type_id']);
            $table->dropColumn('collection_type_id');
        });
    }

    public function down()
    {
        Schema::table('collection_fields', function (Blueprint $table) {
            $table->unsignedBigInteger('collection_type_id')->nullable()->after('account_id');
            $table->foreign('collection_type_id')->references('id')->on('collection_types')->onDelete('cascade');
        });

        foreach (DB::table('collection_field_type')->get() as $link) {
            DB::table('collection_fields')
                ->where('id', $link->collection_field_id)
                ->whereNull('collection_type_id')
                ->update(['collection_type_id' => $link->collection_type_id]);
        }

        Schema::dropIfExists('collection_field_type');
    }
};
