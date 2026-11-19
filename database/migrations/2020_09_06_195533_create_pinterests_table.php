<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration original perdida do repositório (não estava versionada, mas já havia rodado em
 * produção/local). Recriada a partir do schema real da tabela `pinterests` (SHOW CREATE TABLE),
 * excluindo as colunas que outras migrations ainda presentes no repositório adicionam depois
 * (`linked_site`, em 2020_09_08_143703_add_column_linked_site_in_pinterests).
 */
class CreatePinterestsTable extends Migration
{
    public function up()
    {
        Schema::create('pinterests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('page_name');
            $table->string('URL_name');
            $table->string('status');
            $table->string('business');
            $table->string('same_site_name');
            $table->string('about');
            $table->string('pin_content');
            $table->string('value_ads');
            $table->timestamps();
            $table->foreignId('account_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pinterests');
    }
}
