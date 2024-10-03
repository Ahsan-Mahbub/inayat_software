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
        Schema::create('sale_requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->string('requisition_number')->nullable();
            $table->bigInteger('customer_id')->unsigned()->index()->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->float('subtotal', 12, 2)->default(0)->nullable();
            $table->integer('percentage')->default(0)->nullable();
            $table->float('discount', 12, 2)->default(0)->nullable();
            $table->float('discount_price', 12, 2)->default(0)->nullable();
            $table->float('vat', 12, 2)->default(0)->nullable();
            $table->float('total_amount', 12, 2)->default(0)->nullable();
            $table->integer('status')->default(0)->nullable();
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
        Schema::dropIfExists('sale_requisitions');
    }
};
