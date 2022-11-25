<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollAgeScoresTable extends Migration
{
    public function up()
    {
        Schema::create('poll_age_scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('order')->nullable();
            $table->integer('age_start')->nullable();
            $table->integer('end_range')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
