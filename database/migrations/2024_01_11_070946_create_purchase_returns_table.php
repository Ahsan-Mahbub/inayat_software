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
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('purchase_id')->unsigned()->index()->nullable();
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
            $table->bigInteger('supplier_id')->unsigned()->index()->nullable();
            $table->bigInteger('product_id')->unsigned()->index()->nullable();
            $table->integer('qty')->default(0)->nullable();
            $table->float('amount', 8, 2)->default(0)->nullable();
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
        Schema::dropIfExists('purchase_returns');
    }
};
