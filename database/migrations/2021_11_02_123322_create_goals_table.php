<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id');
                        $table->string('department');
            $table->string('name');
            $table->text('description');
            $table->decimal('points', 4, 1)->nullable();
            $table->timestamp('date_start');
            $table->timestamp('date_due');
            $table->timestamp('date_conclusion');
            $table->integer('goals_contacts')->nullable();
            $table->decimal('goals_points', 4, 1)->nullable();
            $table->decimal('goals_invoice_revenues', 8, 2)->nullable();
            $table->decimal('goals_invoice_expenses', 8, 2)->nullable();
            $table->decimal('goals_transactions_expenses', 8, 2)->nullable();
            $table->decimal('goals_transactions_revenues', 8, 2)->nullable(); 
            $table->integer('goals_opportunities')->nullable();
            $table->integer('goals_opportunities_won')->nullable();
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
    public function down()
    {
        Schema::dropIfExists('goals');
    }
}
