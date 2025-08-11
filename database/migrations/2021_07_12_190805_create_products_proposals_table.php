<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsProposalsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('products_proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id');
            $table->foreignId('product_id');
            $table->integer('amount');
            $table->decimal('subtotalHours', 5, 1)->nullable();
            $table->integer('subtotalDeadline')->nullable();
            $table->integer('subtotalCost')->nullable();
            $table->integer('subtotalTax_rate')->nullable();
            $table->decimal('subtotalPrice', 8, 2);
            $table->decimal('subtotalMargin', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('products_proposals');
    }

}
