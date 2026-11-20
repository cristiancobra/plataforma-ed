<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration original perdida do repositório (não estava versionada, mas já havia rodado em
 * produção/local). Recriada a partir do schema real da tabela `twitters` (SHOW CREATE TABLE).
 */
class CreateTwittersTable extends Migration
{
    public function up()
    {
        Schema::create('twitters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->string('page_name');
            $table->string('URL_name');
            $table->string('status');
            $table->string('business');
            $table->string('linked_facebook');
            $table->string('linked_site');
            $table->string('same_site_name');
            $table->string('about');
            $table->string('feed_content');
            $table->string('value_ads');
            $table->timestamps();
            $table->foreignId('account_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('twitters');
    }
}
