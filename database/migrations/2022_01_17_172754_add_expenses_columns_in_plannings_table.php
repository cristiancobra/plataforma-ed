<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpensesColumnsInPlanningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plannings', function (Blueprint $table) {
                                    $table->decimal('expenses_accounting', 8, 2);
                                    $table->decimal('expenses_production', 8, 2);
                                    $table->decimal('expenses_marketing', 8, 2);
                                    $table->decimal('expenses_salary', 8, 2);
                                    $table->decimal('expenses_prolabore', 8, 2);
                                    $table->decimal('expenses_legal', 8, 2);
                                    $table->decimal('expenses_infrastructure', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plannings', function (Blueprint $table) {
            $table->dropColumn('expenses_accounting');
            $table->dropColumn('expenses_production');
            $table->dropColumn('expenses_marketing');
            $table->dropColumn('expenses_salary');
            $table->dropColumn('expenses_prolabore');
            $table->dropColumn('expenses_legal');
            $table->dropColumn('expenses_infrastructure');
        });
    }
}
