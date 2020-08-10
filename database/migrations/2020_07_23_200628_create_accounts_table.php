<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
	$table->foreignId('user_id')->constrained();
	$table->string('name');
	$table->string('email');
	$table->string('phone');
	$table->string('site');
	$table->string('address');
	$table->string('address_city');
	$table->string('address_state');
	$table->string('address_country');
	$table->string('type');
	$table->tinyInteger('employees');
	$table->text('description');			
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
        Schema::dropIfExists('accounts');
    }
}
