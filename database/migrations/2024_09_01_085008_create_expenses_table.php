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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->bigInteger('head_id')->unsigned()->index()->nullable();
            $table->foreign('head_id')->references('id')->on('heads')->onDelete('cascade');
            $table->bigInteger('subhead_id')->unsigned()->index()->nullable();
            $table->foreign('subhead_id')->references('id')->on('sub_heads')->onDelete('cascade');
            $table->bigInteger('employee_id')->unsigned()->index()->nullable();
            $table->float('amount', 12, 2)->default(0)->nullable();
            $table->text('reason')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('expenses');
    }
};
