<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSocialmediasTableChangeBinaryToEnum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('socialmedias', function (Blueprint $table) {
            // Alterar campos de tinyInteger para string
            $table->string('business', 20)->nullable()->change();
            $table->string('linked_instagram', 20)->nullable()->change();
            $table->string('linked_facebook', 20)->nullable()->change();
            $table->string('same_site_name', 20)->nullable()->change();
            $table->string('about', 20)->nullable()->change();
            $table->string('feed_content', 20)->nullable()->change();
            $table->string('harmonic_feed', 20)->nullable()->change();
            $table->string('SEO_descriptions', 20)->nullable()->change();
            $table->string('feed_images', 20)->nullable()->change();
            $table->string('stories', 20)->nullable()->change();
            $table->string('interaction', 20)->nullable()->change();
            $table->string('igtv', 20)->nullable()->change();
            $table->string('reels', 20)->nullable()->change();
            $table->string('employee_profiles', 20)->nullable()->change();
            $table->string('employee_profiles_cv', 20)->nullable()->change();
            $table->string('offers_job', 20)->nullable()->change();
            $table->string('pin_content', 20)->nullable()->change();
            $table->string('linktree', 20)->nullable()->change();
            $table->string('image_banner', 20)->nullable()->change();
            $table->string('organized_playlists', 20)->nullable()->change();
            $table->string('liked_virtualstore', 20)->nullable()->change();
            $table->string('video_banner', 20)->nullable()->change();
            $table->string('legend', 20)->nullable()->change();
            $table->string('feed_member', 20)->nullable()->change();
            $table->string('follow_channel', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('socialmedias', function (Blueprint $table) {
            // Reverter para tinyInteger
            $table->tinyInteger('business')->nullable()->change();
            $table->tinyInteger('linked_instagram')->nullable()->change();
            $table->tinyInteger('linked_facebook')->nullable()->change();
            $table->tinyInteger('same_site_name')->nullable()->change();
            $table->tinyInteger('about')->nullable()->change();
            $table->tinyInteger('feed_content')->nullable()->change();
            $table->tinyInteger('harmonic_feed')->nullable()->change();
            $table->tinyInteger('SEO_descriptions')->nullable()->change();
            $table->tinyInteger('feed_images')->nullable()->change();
            $table->tinyInteger('stories')->nullable()->change();
            $table->tinyInteger('interaction')->nullable()->change();
            $table->tinyInteger('igtv')->nullable()->change();
            $table->tinyInteger('reels')->nullable()->change();
            $table->tinyInteger('employee_profiles')->nullable()->change();
            $table->tinyInteger('employee_profiles_cv')->nullable()->change();
            $table->tinyInteger('offers_job')->nullable()->change();
            $table->tinyInteger('pin_content')->nullable()->change();
            $table->tinyInteger('linktree')->nullable()->change();
            $table->tinyInteger('image_banner')->nullable()->change();
            $table->tinyInteger('organized_playlists')->nullable()->change();
            $table->tinyInteger('liked_virtualstore')->nullable()->change();
            $table->tinyInteger('video_banner')->nullable()->change();
            $table->tinyInteger('legend')->nullable()->change();
            $table->tinyInteger('feed_member')->nullable()->change();
            $table->tinyInteger('follow_channel')->nullable()->change();
        });
    }
}