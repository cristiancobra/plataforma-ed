<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id');
            $table->foreignId('lender_user_id');
            $table->foreignId('borrower_user_id')->nullable();
            $table->foreignId('borrower_contact_id')->nullable();
            $table->date('start_date');
            $table->date('due_date');
            $table->date('returned_date')->nullable();
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->tinyInteger('trash')->default(0);
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
        Schema::dropIfExists('loans');
    }
}
