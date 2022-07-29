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
        Schema::create('signs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('base_blank_id');
            $table->unsignedBigInteger('base_color_id');
            $table->dateTime('sign_time');
            $table->timestamps();

            $table->foreign('base_blank_id')->references('id')->on('rolls');
            $table->foreign('base_color_id')->references('id')->on('rolls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('signs');
    }
};
