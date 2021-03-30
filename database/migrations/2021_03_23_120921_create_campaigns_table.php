<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->required();
            $table->foreignId('user_id');
            $table->foreignId('email_id');
            $table->string('name');
            $table->date("send_date");
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('campaigns');
    }

}
