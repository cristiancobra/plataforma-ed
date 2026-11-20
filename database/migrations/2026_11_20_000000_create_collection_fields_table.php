<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Definições dos campos personalizados dos itens de acervo, criadas pelo próprio cliente.
     * Os valores ficam na coluna JSON collections.custom_fields, indexados pela `key`.
     */
    public function up()
    {
        Schema::create('collection_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            // null = o campo aparece em todos os itens; preenchido = só nos itens daquele tipo
            $table->unsignedBigInteger('collection_type_id')->nullable();
            $table->string('label');
            $table->string('key', 100);
            $table->string('type', 30);
            $table->json('options')->nullable();
            $table->boolean('required')->default(false);
            $table->unsignedInteger('position')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('collection_type_id')->references('id')->on('collection_types')->onDelete('cascade');
            $table->unique(['account_id', 'key']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('collection_fields');
    }
};
