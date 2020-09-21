<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompetitorsColumnsInReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('reports', function (Blueprint $table) {
			$table->string('account_id');
			$table->string('CP1_name');
			$table->string('CP1_description');
			$table->string('CP1_site');
			$table->string('CP1_site_keywords');
			$table->string('CP1_site_organic_traffic');
			$table->string('CP1_site_backlinks');
			$table->decimal('CP1_site_domain_score');
			$table->string('CP1_google_business');
			$table->string('CP1_google_business_score');
			$table->mediumInteger('CP1_google_business_comments');
			$table->string('CP1_ifood');
			$table->decimal('CP1_ifood_score');
			$table->mediumInteger('CP1_ifood_comments');
			$table->string('CP1_spotify');
			$table->string('CP1_city');
			$table->string('CP1_state');
			$table->string('CP1_type');
			$table->mediumInteger('CP1_facebook_followers');
			$table->mediumInteger('CP1_instagram_followers');
			$table->mediumInteger('CP1_linkedin_followers');
			$table->mediumInteger('CP1_twitter_followers');
			$table->mediumInteger('CP1_youtube_followers');
			$table->mediumInteger('CP1_spotfy_followers');

			$table->string('CP2_name');
			$table->string('CP2_description');
			$table->string('CP2_site');
			$table->string('CP2_site_keywords');
			$table->string('CP2_site_organic_traffic');
			$table->string('CP2_site_backlinks');
			$table->decimal('CP2_site_domain_score');
			$table->string('CP2_google_business');
			$table->decimal('CP2_google_business_score');
			$table->mediumInteger('CP2_google_business_comments');
			$table->string('CP2_ifood');
			$table->string('CP2_ifood_score');
			$table->mediumInteger('CP2_ifood_comments');
			$table->string('CP2_spotify');
			$table->string('CP2_city');
			$table->string('CP2_state');
			$table->string('CP2_type');
			$table->mediumInteger('CP2_facebook_followers');
			$table->mediumInteger('CP2_instagram_followers');
			$table->mediumInteger('CP2_linkedin_followers');
			$table->mediumInteger('CP2_twitter_followers');
			$table->mediumInteger('CP2_pinterest_followers');
			$table->mediumInteger('CP2_youtube_followers');
			$table->mediumInteger('CP2_spotfy_followers');

			$table->string('CP3_name');
			$table->string('CP3_description');
			$table->string('CP3_site');
			$table->string('CP3_site_keywords');
			$table->string('CP3_site_organic_traffic');
			$table->string('CP3_site_backlinks');
			$table->string('CP3_site_domain_score');
			$table->string('CP3_google_business');
			$table->decimal('CP3_google_business_score');
			$table->mediumInteger('CP3_google_business_comments');
			$table->string('CP3_ifood');
			$table->decimal('CP3_ifood_score');
			$table->mediumInteger('CP3_ifood_comments');
			$table->string('CP3_spotify');
			$table->string('CP3_city');
			$table->string('CP3_state');
			$table->string('CP3_type');
			$table->mediumInteger('CP3_facebook_followers');
			$table->mediumInteger('CP3_instagram_followers');
			$table->mediumInteger('CP3_linkedin_followers');
			$table->mediumInteger('CP3_twitter_followers');
			$table->mediumInteger('CP3_pinterest_followers');
			$table->mediumInteger('CP3_youtube_followers');
			$table->mediumInteger('CP3_spotfy_followers');
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
				'account_id',
				'CP1_name',
				'CP1_description',
				'CP1_site',
				'CP1_site_keywords',
				'CP1_site_organic_traffic',
				'CP1_site_backlinks',
				'CP1_site_domain_score',
				'CP1_google_business',
				'CP1_google_business_score',
				'CP1_google_business_comments',
				'CP1_ifood',
				'CP1_ifood_score',
				'CP1_ifood_comments',
				'CP1_spotify',
				'CP1_city',
				'CP1_state',
				'CP1_type',
				'CP1_facebook_followers',
				'CP1_instagram_followers',
				'CP1_linkedin_followers',
				'CP1_twitter_followers',
				'CP1_pinterest_followers',
				
				'CP2_name',
				'CP2_description',
				'CP2_site',
				'CP2_site_keywords',
				'CP2_site_organic_traffic',
				'CP2_site_backlinks',
				'CP2_site_domain_score',
				'CP2_google_business',
				'CP2_google_business_score',
				'CP2_google_business_comments',
				'CP2_ifood',
				'CP2_ifood_score',
				'CP2_ifood_comments',
				'CP2_spotify',
				'CP2_city',
				'CP2_state',
				'CP2_type',
				'CP2_facebook_followers',
				'CP2_instagram_followers',
				'CP2_linkedin_followers',
				'CP2_twitter_followers',
				'CP2_pinterest_followers',
				
				'CP3_name',
				'CP3_description',
				'CP3_site',
				'CP3_site_keywords',
				'CP3_site_organic_traffic',
				'CP3_site_backlinks',
				'CP3_site_domain_score',
				'CP3_google_business',
				'CP3_google_business_score',
				'CP3_google_business_comments',
				'CP3_ifood',
				'CP3_ifood_score',
				'CP3_ifood_comments',
				'CP3_spotify',
				'CP3_city',
				'CP3_state',
				'CP3_type',
				'CP3_facebook_followers',
				'CP3_instagram_followers',
				'CP3_linkedin_followers',
				'CP3_twitter_followers',
				'CP3_pinterest_followers',
			]);
		});
	}

}
