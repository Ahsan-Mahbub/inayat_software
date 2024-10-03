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
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->string('requisition_number')->nullable();
            $table->bigInteger('supplier_id')->unsigned()->index()->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
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
        Schema::dropIfExists('requisitions');
    }
};
