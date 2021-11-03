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
            $table->dateTime('date_start');
            $table->dateTime('date_due');
            $table->dateTime('date_conclusion');
            $table->integer('goal_contacts')->nullable();
            $table->tinyInteger('goal_points')->nullable();
            $table->decimal('goal_invoices_revenues', 8, 2)->nullable();
            $table->decimal('goal_invoices_expenses', 8, 2)->nullable();
            $table->decimal('goal_transactions_expenses', 8, 2)->nullable();
            $table->decimal('goal_transactions_revenues', 8, 2)->nullable(); 
            $table->integer('goal_opportunities')->nullable();
            $table->integer('goal_opportunities_won')->nullable();
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
