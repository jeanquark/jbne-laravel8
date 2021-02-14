<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermanencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permanences', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('year')->nullable();
            $table->integer('quarter')->nullable();
            $table->integer('month')->nullable();
            $table->boolean('week1_dispo')->nullable();
            $table->boolean('week1_attr')->nullable();
            $table->integer('week1_nb')->nullable();
            $table->boolean('week2_dispo')->nullable();
            $table->boolean('week2_attr')->nullable();
            $table->integer('week2_nb')->nullable();
            $table->boolean('week3_dispo')->nullable();
            $table->boolean('week3_attr')->nullable();
            $table->integer('week3_nb')->nullable();
            $table->boolean('week4_dispo')->nullable();
            $table->boolean('week4_attr')->nullable();
            $table->integer('week4_nb')->nullable();
            $table->boolean('week5_dispo')->nullable();
            $table->boolean('week5_attr')->nullable();
            $table->integer('week5_nb')->nullable();
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
        Schema::dropIfExists('permanences');
    }
}
