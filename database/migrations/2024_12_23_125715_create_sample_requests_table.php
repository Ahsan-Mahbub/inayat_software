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
        Schema::create('sample_requests', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->bigInteger('creator_id')->unsigned()->index()->nullable();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('editor_id')->unsigned()->index()->nullable();
            $table->foreign('editor_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('customer_id')->unsigned()->index()->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->string('request_number')->nullable();
            $table->integer('status')->default(0);
            $table->integer('duplicate_requ')->nullable();
            $table->float('subtotal', 12, 2)->default(0)->nullable();
            $table->float('discount', 12, 2)->default(0)->nullable();
            $table->float('percentage', 12, 2)->default(0)->nullable();
            $table->float('discount_price', 12, 2)->default(0)->nullable();
            $table->float('vat', 12, 2)->default(0)->nullable();
            $table->float('tax', 12, 2)->default(0)->nullable();
            $table->float('ait', 12, 2)->default(0)->nullable();
            $table->float('vat_amount', 12, 2)->default(0)->nullable();
            $table->float('tax_amount', 12, 2)->default(0)->nullable();
            $table->float('ait_amount', 12, 2)->default(0)->nullable();
            $table->float('total_amount', 12, 2)->default(0)->nullable();
            $table->text('trams_condition')->nullable();
            $table->integer('show_terms')->default(0);
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
        Schema::dropIfExists('sample_requests');
    }
};
