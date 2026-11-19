<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration original perdida do repositório (não estava versionada, mas já havia rodado em
 * produção/local). Recriada a partir do schema real da tabela `facebooks` (SHOW CREATE TABLE).
 */
class CreateFacebooksTable extends Migration
{
    public function up()
    {
        Schema::create('facebooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->string('page_name');
            $table->string('URL_name');
            $table->string('status');
            $table->string('business');
            $table->string('linked_instagram');
            $table->string('same_site_name');
            $table->string('about');
            $table->string('feed_content');
            $table->string('harmonic_feed');
            $table->string('SEO_descriptions');
            $table->string('feed_images');
            $table->string('stories');
            $table->string('interaction');
            $table->string('value_ads');
            $table->timestamps();
            $table->foreignId('account_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('facebooks');
    }
}
