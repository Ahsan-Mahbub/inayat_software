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
        Schema::create('expense_requisitions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('head_id')->unsigned()->index()->nullable();
            $table->foreign('head_id')->references('id')->on('heads')->onDelete('cascade');
            $table->bigInteger('subhead_id')->unsigned()->index()->nullable();
            $table->foreign('subhead_id')->references('id')->on('sub_heads')->onDelete('cascade');
            $table->bigInteger('employee_id')->unsigned()->index()->nullable();
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('accessor_id')->unsigned()->index()->nullable();
            $table->foreign('accessor_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('date')->nullable();
            $table->string('requisition')->nullable();
            $table->float('request_amount', 12, 2)->default(0)->nullable();
            $table->float('amount', 12, 2)->default(0)->nullable();
            $table->text('reason')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('expense_requisitions');
    }
};
