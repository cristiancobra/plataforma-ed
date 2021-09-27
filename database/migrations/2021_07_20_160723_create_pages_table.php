<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
                    //page fields
            $table->id();
            $table->foreignId('account_id');
            $table->string('name');
            $table->string('url')->nullable();
            $table->string('slug')->nullable();
            $table->string('template');
            $table->foreignId('banner_image_id')->nullable();
            $table->string('headline')->nullable();
            $table->text('text1')->nullable();
            $table->text('text2')->nullable();
            $table->string('principal_color')->nullable();
            $table->string('complementary_color')->nullable();
            $table->string('opposite_color')->nullable();
            $table->tinyInteger('shop')->nullable();

            // contact fields
//            $table->tinyInteger('name');
            $table->tinyInteger('contact_first_name');
            $table->tinyInteger('contact_last_name')->nullable();
            $table->tinyInteger('contact_email')->nullable();
            $table->tinyInteger('contact_phone')->nullable();
            $table->tinyInteger('contact_site')->nullable();
            $table->tinyInteger('contact_address')->nullable();
            $table->tinyInteger('contact_neighborhood')->nullable();
            $table->tinyInteger('contact_city')->nullable();
            $table->tinyInteger('contact_state')->nullable();
            $table->tinyInteger('contact_country')->nullable();
            $table->tinyInteger('contact_job_position')->nullable();
            $table->tinyInteger('contact_date_birth')->nullable();
            $table->string('contact_access_profile')->nullable();
            $table->tinyInteger('contact_profession')->nullable();
            $table->tinyInteger('contact_religion')->nullable();
            $table->tinyInteger('contact_etinicity')->nullable();
            $table->tinyInteger('contact_naturality')->nullable();
            $table->tinyInteger('contact_gender')->nullable();
            $table->tinyInteger('contact_schollarity')->nullable();
            $table->tinyInteger('contact_civil_state')->nullable();
            $table->tinyInteger('contact_kids')->nullable();
            $table->tinyInteger('contact_hobbie')->nullable();
            $table->tinyInteger('contact_instagram')->nullable();
            $table->tinyInteger('contact_facebook')->nullable();
            $table->tinyInteger('contact_linkedin')->nullable();
            $table->tinyInteger('contact_twitter')->nullable();
            $table->string('contact_lead_source')->nullable();
            $table->string('contact_type')->nullable();

            // company fields
            $table->tinyInteger('company_name')->nullable();
            $table->tinyInteger('company_income')->nullable();
            $table->tinyInteger('company_site')->nullable();
            $table->tinyInteger('company_phone')->nullable();
            $table->tinyInteger('company_cnpj')->nullable();
            $table->tinyInteger('company_type')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('pages');
    }
}
