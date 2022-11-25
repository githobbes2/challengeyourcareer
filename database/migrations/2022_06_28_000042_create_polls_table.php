<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollsTable extends Migration
{
    public function up()
    {
        Schema::create('polls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('label_1')->nullable();
            $table->string('label_2')->nullable();
            $table->string('label_3')->nullable();
            $table->string('label_4')->nullable();
            $table->string('label_5')->nullable();
            $table->boolean('use_age_score')->default(0)->nullable();
            $table->boolean('use_language_score')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
