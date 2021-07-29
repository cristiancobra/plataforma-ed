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
            $table->date('date_creation');
            $table->text('observations')->nullable();
            $table->decimal('increased_expenses', 3, 1)->nullable();
            $table->decimal('growth_rate', 3, 1)->nullable();
            $table->decimal('total_hours', 5, 1)->nullable();
            $table->integer('total_amount')->nullable();
            $table->integer('total_cost')->nullable();
            $table->integer('total_tax_rate')->nullable();
            $table->integer('total_price')->nullable();
            $table->integer('total_margin')->nullable();
            $table->integer('total_balance')->nullable();
            $table->string('type');
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
