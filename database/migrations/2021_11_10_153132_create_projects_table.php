<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id');
            $table->foreignId('user_id');
            $table->foreignId('contact_id');
            $table->foreignId('company_id')->nullable();
            $table->foreignId('goal_id');
            $table->string('name');
            $table->string('department')->nullable();
            $table->dateTime('date_start');
            $table->dateTime('date_due');
            $table->dateTime('date_conclusion')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('trash');
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
        Schema::dropIfExists('projects');
    }

}
