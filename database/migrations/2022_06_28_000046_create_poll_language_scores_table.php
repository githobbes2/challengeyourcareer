<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollLanguageScoresTable extends Migration
{
    public function up()
    {
        Schema::create('poll_language_scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('points', 3, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
