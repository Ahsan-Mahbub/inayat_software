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
        Schema::create('sale_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sale_id')->unsigned()->index()->nullable();
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
            $table->bigInteger('product_id')->unsigned()->index()->nullable();
            $table->bigInteger('unit_id')->unsigned()->index()->nullable();
            $table->string('size')->default(0)->nullable();
            $table->integer('qty')->default(0)->nullable();
            $table->float('amount', 8, 2)->default(0)->nullable();
            $table->bigInteger('actual_unit_id')->unsigned()->index()->nullable();
            $table->integer('actual_qty')->default(0)->nullable();
            $table->float('actual_amount', 8, 2)->default(0)->nullable();
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
        Schema::dropIfExists('sale_products');
    }
};
