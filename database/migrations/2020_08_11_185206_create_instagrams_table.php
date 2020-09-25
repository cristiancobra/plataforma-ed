<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstagramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instagrams', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id');
			$table->string('page_name');
			$table->string('URL_name');
			$table->string('status');
			$table->string('business');
			$table->string('linked_facebook');
			$table->string('same_site_name');
			$table->string('about');
			$table->string('feed_content');
			$table->string('harmonic_feed');
			$table->string('SEO_descriptions');
			$table->string('feed_images');
			$table->string('stories');
			$table->string('interaction');
			$table->string('value_ads');
			$table->string('linktree');
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instagrams');
    }
}
