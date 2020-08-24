<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinkedinColumnsToReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            		$table->string('IN_page_name');
			$table->string('IN_URL_name');
			$table->string('IN_business');
			$table->string('IN_same_site_name');
			$table->string('IN_about');
			$table->string('IN_feed_content');
			$table->string('IN_SEO_descriptions');
			$table->string('IN_feed_images');
			$table->string('IN_value_ads');
			$table->string('IN_employee_profiles');
			$table->string('IN_offers_job');		
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
			$table->dropColumn([
				'IN_page_name',
				'IN_URL_name',
				'IN_business',
				'IN_same_site_name',
				'IN_about',
				'IN_feed_content',
				'IN_SEO_descriptions',
				'IN_feed_images',
				'IN_value_ads',
				'IN_employee_profiles',
				'IN_offers_job',
				]);
        });
    }
}
