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
        Schema::create('sale_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->bigInteger('customer_id')->unsigned()->index()->nullable();
            $table->bigInteger('sale_id')->unsigned()->index()->nullable();
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
            $table->bigInteger('method_id')->unsigned()->index()->nullable();
            $table->bigInteger('account_id')->unsigned()->index()->nullable();
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
        Schema::dropIfExists('sale_transactions');
    }
};
