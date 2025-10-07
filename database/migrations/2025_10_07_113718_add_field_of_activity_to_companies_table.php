<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldOfActivityToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('field_of_activity_1')->nullable();
            $table->string('field_of_activity_2')->nullable();
            $table->string('field_of_activity_3')->nullable();
            $table->string('field_of_activity_4')->nullable();
            $table->string('field_of_activity_5')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'field_of_activity_1',
                'field_of_activity_2',
                'field_of_activity_3',
                'field_of_activity_4',
                'field_of_activity_5',
            ]);
        });
    }
}
