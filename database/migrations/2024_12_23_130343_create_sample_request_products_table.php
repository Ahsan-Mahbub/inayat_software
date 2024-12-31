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
        Schema::create('sample_request_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('request_id')->unsigned()->index()->nullable();
            $table->foreign('request_id')->references('id')->on('sample_requests')->onDelete('cascade');
            $table->bigInteger('product_id')->unsigned()->index()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('des_show')->default(0);
            $table->text('description')->nullable();
            $table->bigInteger('unit_id')->unsigned()->index()->nullable();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->float('sale_price', 12, 2)->default(0)->nullable();
            $table->integer('qty')->nullable();
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
        Schema::dropIfExists('sample_request_products');
    }
};
