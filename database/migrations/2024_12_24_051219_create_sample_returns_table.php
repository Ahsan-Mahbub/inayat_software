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
        Schema::create('sample_returns', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->bigInteger('creator_id')->unsigned()->index()->nullable();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('request_id')->unsigned()->index()->nullable();
            $table->foreign('request_id')->references('id')->on('sample_requests')->onDelete('cascade');
            $table->bigInteger('customer_id')->unsigned()->index()->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->bigInteger('product_id')->unsigned()->index()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->bigInteger('unit_id')->unsigned()->index()->nullable();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->bigInteger('request_product_id')->unsigned()->index()->nullable();
            $table->foreign('request_product_id')->references('id')->on('sample_request_products')->onDelete('cascade');
            $table->integer('qty')->nullable();
            $table->float('amount', 12, 2)->default(0)->nullable();
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
        Schema::dropIfExists('sample_returns');
    }
};
