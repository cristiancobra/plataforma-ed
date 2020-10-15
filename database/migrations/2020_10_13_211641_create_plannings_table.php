<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plannings', function (Blueprint $table) {
            $table->id();
	$table->foreignId('account_id');
	$table->string('name');
	$table->integer('months');
	$table->integer('expenses')->nullable();

	$table->string('name1')->nullable();
	$table->integer('amount1')->nullable();
	$table->decimal('hours1', 5, 1)->nullable();
	$table->integer('cost1')->nullable();
	$table->integer('tax_rate1')->nullable();
	$table->integer('price1')->nullable();

	$table->string('name2')->nullable();
	$table->integer('amount2')->nullable();
	$table->decimal('hours2', 5, 1)->nullable();
	$table->integer('cost2')->nullable();
	$table->integer('tax_rate2')->nullable();
	$table->integer('price2')->nullable();

	$table->string('name3')->nullable();
	$table->integer('amount3')->nullable();
	$table->decimal('hours3', 5, 1)->nullable();
	$table->integer('cost3')->nullable();
	$table->integer('tax_rate3')->nullable();
	$table->integer('price3')->nullable();
	
	$table->string('name4')->nullable();
	$table->integer('amount4')->nullable();
	$table->decimal('hours4', 5, 1)->nullable();
	$table->integer('cost4')->nullable();
	$table->integer('tax_rate4')->nullable();
	$table->integer('price4')->nullable();
	
	$table->string('name5')->nullable();
	$table->integer('amount5')->nullable();
	$table->decimal('hours5', 5, 1)->nullable();
	$table->integer('cost5')->nullable();
	$table->integer('tax_rate5')->nullable();
	$table->integer('price5')->nullable();
	
	$table->string('name6')->nullable();
	$table->integer('amount6')->nullable();
	$table->decimal('hours6', 5, 1)->nullable();
	$table->integer('cost6')->nullable();
	$table->integer('tax_rate6')->nullable();
	$table->integer('price6')->nullable();
	
	$table->string('name7')->nullable();
	$table->integer('amount7')->nullable();
	$table->decimal('hours7', 5, 1)->nullable();
	$table->integer('cost7')->nullable();
	$table->integer('tax_rate7')->nullable();
	$table->integer('price7')->nullable();
	
	$table->string('name8')->nullable();
	$table->integer('amount8')->nullable();
	$table->decimal('hours8', 5, 1)->nullable();
	$table->integer('cost8')->nullable();
	$table->integer('tax_rate8')->nullable();
	$table->integer('price8')->nullable();
	
	$table->integer('name9')->nullable();
	$table->integer('amount9')->nullable();
	$table->decimal('hours9', 5, 1)->nullable();
	$table->integer('cost9')->nullable();
	$table->integer('tax_rate9')->nullable();
	$table->integer('price9')->nullable();
	
	$table->integer('name10')->nullable();
	$table->integer('amount10')->nullable();
	$table->decimal('hours10', 5, 1)->nullable();
	$table->integer('cost10')->nullable();
	$table->integer('tax_rate10')->nullable();
	$table->integer('price10')->nullable();
	
	$table->integer('name11')->nullable();
	$table->integer('amount11')->nullable();
	$table->decimal('hours11', 5, 1)->nullable();
	$table->integer('cost11')->nullable();
	$table->integer('tax_rate11')->nullable();
	$table->integer('price11')->nullable();
	
	$table->integer('name12')->nullable();
	$table->integer('amount12')->nullable();
	$table->decimal('hours12', 5, 1)->nullable();
	$table->integer('cost12')->nullable();
	$table->integer('tax_rate12')->nullable();
	$table->integer('price12')->nullable();
	
	$table->integer('name13')->nullable();
	$table->integer('amount13')->nullable();
	$table->decimal('hours13', 5, 1)->nullable();
	$table->integer('cost13')->nullable();
	$table->integer('tax_rate13')->nullable();
	$table->integer('price13')->nullable();
	
	$table->integer('name14')->nullable();
	$table->integer('amount14')->nullable();
	$table->decimal('hours14', 5, 1)->nullable();
	$table->integer('cost14')->nullable();
	$table->integer('tax_rate14')->nullable();
	$table->integer('price14')->nullable();
	
	$table->integer('name15')->nullable();
	$table->integer('amount15')->nullable();
	$table->decimal('hours15', 5, 1)->nullable();
	$table->integer('cost15')->nullable();
	$table->integer('tax_rate15')->nullable();
	$table->integer('price15')->nullable();
	
	$table->integer('name16')->nullable();
	$table->integer('amount16')->nullable();
	$table->decimal('hours16', 5, 1)->nullable();
	$table->integer('cost16')->nullable();
	$table->integer('tax_rate16')->nullable();
	$table->integer('price16')->nullable();
	
	$table->integer('name17')->nullable();
	$table->integer('amount17')->nullable();
	$table->decimal('hours17', 5, 1)->nullable();
	$table->integer('cost17')->nullable();
	$table->integer('tax_rate17')->nullable();
	$table->integer('price17')->nullable();
	
	$table->integer('name18')->nullable();
	$table->integer('amount18')->nullable();
	$table->decimal('hours18', 5, 1)->nullable();
	$table->integer('cost18')->nullable();
	$table->integer('tax_rate18')->nullable();
	$table->integer('price18')->nullable();
	
	$table->integer('name19')->nullable();
	$table->integer('amount19')->nullable();
	$table->decimal('hours19', 5, 1)->nullable();
	$table->integer('cost19')->nullable();
	$table->integer('tax_rate19')->nullable();
	$table->integer('price19')->nullable();
	
	$table->integer('name20')->nullable();
	$table->integer('amount20')->nullable();
	$table->decimal('hours20', 5, 1)->nullable();
	$table->integer('cost20')->nullable();
	$table->integer('tax_rate20')->nullable();
	$table->integer('price20')->nullable();
	
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
        Schema::dropIfExists('plannings');
    }
}
