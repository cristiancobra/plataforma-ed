<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsPlanningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_plannings', function (Blueprint $table) {
			$table->foreignId('planning_id');
			$table->foreignId('product_id');
			$table->integer('amount');
			$table->integer('subtotal_cost')->nullable();
			$table->integer('subtotal_tax_rate')->nullable();
			$table->integer('subtotal_price');
			$table->integer('subtotal_margin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_plannings');
    }
}
