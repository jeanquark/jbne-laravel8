<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->integer('year')->default(0);
            $table->integer('quarter')->default(0);
            $table->integer('month')->default(0);
            $table->string('week1')->default('');
            $table->integer('week1_nb');
            $table->string('week2')->default('');
            $table->integer('week2_nb');
            $table->string('week3')->default('');
            $table->integer('week3_nb');
            $table->string('week4')->default('');
            $table->integer('week4_nb');
            $table->string('week5')->nullable();
            $table->integer('week5_nb')->nullable()->unsigned();
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
        Schema::dropIfExists('calendars');
    }
}
