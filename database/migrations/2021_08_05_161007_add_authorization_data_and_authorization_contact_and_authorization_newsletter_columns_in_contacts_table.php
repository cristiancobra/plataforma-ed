<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthorizationDataAndAuthorizationContactAndAuthorizationNewsletterColumnsInContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->tinyInteger('authorization_data')->nullable();
            $table->tinyInteger('authorization_contact')->nullable();
            $table->tinyInteger('authorization_newsletter')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('authorization_data');
            $table->dropColumn('authorization_contact');
            $table->dropColumn('authorization_newsletter');
        });
    }
}
