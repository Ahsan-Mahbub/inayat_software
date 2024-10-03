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
        Schema::create('purchase_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->bigInteger('supplier_id')->unsigned()->index()->nullable();
            $table->bigInteger('purchase_id')->unsigned()->index()->nullable();
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
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
        Schema::dropIfExists('purchase_transactions');
    }
};
