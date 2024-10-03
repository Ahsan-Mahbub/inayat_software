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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->bigInteger('method_id')->unsigned()->index()->nullable();
            $table->foreign('method_id')->references('id')->on('methods')->onDelete('cascade');
            $table->bigInteger('account_id')->unsigned()->index()->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->bigInteger('employee_id')->unsigned()->index()->nullable();
            $table->float('amount', 12, 2)->default(0)->nullable();
            $table->text('purpose')->nullable();
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
        Schema::dropIfExists('budgets');
    }
};
