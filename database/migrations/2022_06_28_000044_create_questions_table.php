<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->float('points_1', 3, 2)->nullable();
            $table->float('points_2', 3, 2)->nullable();
            $table->float('points_3', 3, 2)->nullable();
            $table->float('points_4', 3, 2)->nullable();
            $table->float('points_5', 3, 2)->nullable();
            $table->integer('experience_points_1')->nullable();
            $table->integer('experience_points_2')->nullable();
            $table->integer('experience_points_3')->nullable();
            $table->integer('experience_points_4')->nullable();
            $table->integer('experience_points_5')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
