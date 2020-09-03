<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsNullableInAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
	$table->string('email')->nullable()->change();
	$table->string('phone')->nullable()->change();
	$table->string('site')->nullable()->change();
	$table->string('address')->nullable()->change();
	$table->string('type')->nullable()->change();
	$table->smallInteger('employees')->nullable()->change();
	$table->text('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts', function (Blueprint $table) {
	$table->string('email')->change();
	$table->string('phone')->change();
	$table->string('site')->change();
	$table->string('address')->change();
	$table->string('type')->change();
	$table->tinyInteger('employees')->change();
	$table->text('description')->change();
        });
    }
}
