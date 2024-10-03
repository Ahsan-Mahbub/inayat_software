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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->string('invoice')->nullable();
            $table->bigInteger('supplier_id')->unsigned()->index()->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->float('subtotal', 8, 2)->default(0)->nullable();
            $table->integer('percentage')->default(0)->nullable();
            $table->float('discount', 8, 2)->default(0)->nullable();
            $table->float('discount_price', 8, 2)->default(0)->nullable();
            $table->float('vat', 8, 2)->default(0)->nullable();
            $table->float('total_amount', 8, 2)->default(0)->nullable();
            $table->float('paid_amount', 8, 2)->default(0)->nullable();
            $table->float('due_amount', 8, 2)->default(0)->nullable();
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
        Schema::dropIfExists('purchases');
    }
};
