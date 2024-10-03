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
        Schema::create('sale_requisition_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('requisition_id')->unsigned()->index()->nullable();
            $table->foreign('requisition_id')->references('id')->on('sale_requisitions')->onDelete('cascade');
            $table->bigInteger('batch_id')->unsigned()->index()->nullable();
            $table->bigInteger('product_id')->unsigned()->index()->nullable();
            $table->float('purchase_price', 12, 2)->default(0)->nullable();
            $table->float('sale_price', 12, 2)->default(0)->nullable();
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
        Schema::dropIfExists('sale_requisition_products');
    }
};
