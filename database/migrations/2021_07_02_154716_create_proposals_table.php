<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->integer('identifier');
            $table->foreignId('account_id');
            $table->foreignId('user_id');
            $table->foreignId('opportunity_id');
            $table->foreignId('company_id')->nullable();
            $table->foreignId('contact_id');
            $table->date('date_creation');
            $table->date('pay_day');
            $table->text('description')->nullable();
            $table->integer('discount')->nullable();
            $table->decimal('totalHours', 5, 1)->nullable();
            $table->decimal('totalPoints', 4, 1)->nullable();
            $table->integer('totalAmount')->nullable();
            $table->integer('totalCost')->nullable();
            $table->integer('totalTax_rate')->nullable();
            $table->integer('totalPrice')->nullable();
            $table->integer('totalMargin')->nullable();
            $table->integer('totalBalance')->nullable();
            $table->string('receipt')->nullable();
            $table->tinyInteger('installment');
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
    public function down() {
        Schema::dropIfExists('proposals');
    }

}
