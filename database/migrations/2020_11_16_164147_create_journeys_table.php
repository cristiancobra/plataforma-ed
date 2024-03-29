<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJourneysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journeys', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_id');
			$table->foreignId('user_id');
			$table->foreignId('task_id');
			$table->text('description')->nullable();
			$table->date('date');
			$table->timestamp('start');
			$table->timestamp('end')->nullable();
			$table->integer('duration')->nullable();
			$table->string('status')->nullable();
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
        Schema::dropIfExists('journeys');
    }
}
