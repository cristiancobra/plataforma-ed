<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYoutubesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('youtubes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('page_name');
            $table->string('URL_name');
            $table->string('status');
            $table->string('image_banner');
            $table->string('organized_playlists');
            $table->string('linked_site');
            $table->string('same_site_name');
            $table->string('about');
            $table->string('seo_content');
            $table->string('feed_member');
            $table->string('follow_channel');
            $table->string('liked_virtualstore');
            $table->string('video_banner');
            $table->string('legend');
            $table->string('feed_content');
            $table->string('value_ads');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('youtubes');
    }

}
