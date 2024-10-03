<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisition_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('requisition_id')->unsigned()->index()->nullable();
            $table->foreign('requisition_id')->references('id')->on('requisitions')->onDelete('cascade');
            $table->bigInteger('product_id')->unsigned()->index()->nullable();
            $table->integer('qty')->default(0)->nullable();
            $table->float('amount', 12, 2)->default(0)->nullable();
            $table->float('discount_amount', 12, 2)->default(0)->nullable();
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
        Schema::dropIfExists('requisition_products');
    }
};
