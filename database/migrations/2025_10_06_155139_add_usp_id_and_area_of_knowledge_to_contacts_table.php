<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUspIdAndAreaOfKnowledgeToContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('usp_id', 8)->nullable();
            $table->string('area_of_knowledge_1')->nullable();
            $table->string('area_of_knowledge_2')->nullable();
            $table->string('area_of_knowledge_3')->nullable();
            $table->string('area_of_knowledge_4')->nullable();
            $table->string('area_of_knowledge_5')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn([
                'usp_id',
                'area_of_knowledge_1',
                'area_of_knowledge_2',
                'area_of_knowledge_3',
                'area_of_knowledge_4',
                'area_of_knowledge_5',
            ]);
        });
    }
}