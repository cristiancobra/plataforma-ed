<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSocialmediasTableChangeBinaryToString extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('socialmedias', function (Blueprint $table) {
            // Alterar campos de boolean para string
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
            // Reverter para boolean
            $table->boolean('business')->nullable()->change();
            $table->boolean('linked_instagram')->nullable()->change();
            $table->boolean('linked_facebook')->nullable()->change();
            $table->boolean('same_site_name')->nullable()->change();
            $table->boolean('about')->nullable()->change();
            $table->boolean('feed_content')->nullable()->change();
            $table->boolean('harmonic_feed')->nullable()->change();
            $table->boolean('SEO_descriptions')->nullable()->change();
            $table->boolean('feed_images')->nullable()->change();
            $table->boolean('stories')->nullable()->change();
            $table->boolean('interaction')->nullable()->change();
            $table->boolean('igtv')->nullable()->change();
            $table->boolean('reels')->nullable()->change();
            $table->boolean('employee_profiles')->nullable()->change();
            $table->boolean('employee_profiles_cv')->nullable()->change();
            $table->boolean('offers_job')->nullable()->change();
            $table->boolean('pin_content')->nullable()->change();
            $table->boolean('linktree')->nullable()->change();
            $table->boolean('image_banner')->nullable()->change();
            $table->boolean('organized_playlists')->nullable()->change();
            $table->boolean('liked_virtualstore')->nullable()->change();
            $table->boolean('video_banner')->nullable()->change();
            $table->boolean('legend')->nullable()->change();
            $table->boolean('feed_member')->nullable()->change();
            $table->boolean('follow_channel')->nullable()->change();
        });
    }
}