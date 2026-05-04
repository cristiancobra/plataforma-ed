<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id');
            $table->foreignId('user_id');
            $table->string('name');
            $table->string('category');
            $table->string('type');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('patrimony_number')->nullable();
            $table->string('control_code')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('manufacturing_date')->nullable();
            $table->string('operating_system')->nullable();
            $table->string('video_card')->nullable();
            $table->string('best_ai')->nullable();
            $table->string('password')->nullable();
            $table->string('users')->nullable();
            $table->string('runs_adobe')->nullable();
            $table->string('runs_vrchat')->nullable();
            $table->string('video_url')->nullable();
            $table->string('code_url')->nullable();
            $table->string('image_url')->nullable();
            $table->tinyInteger('trash')->default(0);
            $table->string('status')->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collections');
    }
}
