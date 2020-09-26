<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPinterestYoutubeSpotfyColumnsToReportsTable extends Migration {/**
 * Run the migrations.
 *
 * @return void
 */

    public function up() {
        Schema::table('reports', function (Blueprint $table) {
            $table->string('PI_page_name', 100);
            $table->string('PI_URL_name');
            $table->string('PI_business', 20);
            $table->string('PI_linked_facebook', 20);
            $table->string('PI_linked_site', 20);
            $table->string('PI_same_site_name', 20);
            $table->string('PI_about', 20);
            $table->string('PI_pin_content', 20);
            $table->decimal('PI_value_ads', 7, 2);

            $table->string('SP_page_name', 100);
            $table->string('SP_URL_name');
            $table->string('SP_same_site_name', 20);
            $table->string('SP_about', 20);
            $table->string('SP_feed_content', 20);
            $table->decimal('SP_value_ads',  7, 2);

            $table->string('YT_page_name', 100);
            $table->string('YT_URL_name');
            $table->string('YT_image_banner', 20);
            $table->string('YT_linked_site', 20);
            $table->string('YT_about', 20);
            $table->string('YT_follow_channel', 20);
            $table->string('YT_feed_member', 20);
            $table->string('YT_linked_virtualstore', 20);
            $table->string('YT_video_banner', 20);
            $table->string('YT_legend', 20);
            $table->string('YT_SEO_content', 20);
            $table->decimal('YT_value_ads',  7, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn([
            'PI_page_name',
            'PI_URL_name',
            'PI_business',
            'PI_linked_facebook',
            'PI_linked_site',
            'PI_same_site_name',
            'PI_about',
            'PI_feed_content',
            'PI_value_ads',
                
            'SP_page_name',        
            'SP_URL_name',
            'SP_same_site_name',
            'SP_about',
            'SP_feed_content',
            'SP_value_ads',

            'YT_page_name',
            'YT_URL_name',
            'YT_personalized_banner',
            'YT_linked_site',
            'YT_about',
            'YT_follow_channel',
            'YT_members_feed',
            'YT_linked_virtual_store',
            'YT_video_banner',
            'YT_legend',
            'YT_SEO_content',
            'YT_value_ads',
                
            ]);
        });
    }

}
