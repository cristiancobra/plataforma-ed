<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('account_id');
            $table->foreignId('opportunity_id');
            $table->string('name');
            $table->text('description');
            $table->decimal('points', 4, 1)->nullable();
            $table->timestamp('start');
            $table->timestamp('end');
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
        Schema::dropIfExists('stages');
    }

}
