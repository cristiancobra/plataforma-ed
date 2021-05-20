<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
           $table->id();
	$table->foreignId('account_id');
	$table->foreignId('image_id')->nullable();
	$table->string('name', 100);
	$table->text('description')->nullable();
	$table->string('category', 50);
	$table->decimal('work_hours', 5, 1)->nullable();
	$table->decimal('cost1', 8,2)->nullable();
	$table->string('cost1_description', 100)->nullable();
	$table->decimal('cost2', 8,2)->nullable();
	$table->string('cost2_description', 100)->nullable();
	$table->decimal('cost3', 8,2)->nullable();
	$table->string('cost3_description', 100)->nullable();
	$table->integer('tax_rate');
	$table->decimal('price', 8,2);
	$table->integer('due_date')->nullable();
	$table->string('status', 50);
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
        Schema::dropIfExists('products');
    }
}
