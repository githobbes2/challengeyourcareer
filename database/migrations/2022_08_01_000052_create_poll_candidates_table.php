<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollCandidatesTable extends Migration
{
    public function up()
    {
        Schema::create('poll_candidates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('score', 5, 2)->nullable();
            $table->integer('experience_points')->nullable();
            $table->integer('age')->nullable();
            $table->string('company')->nullable();
            $table->string('company_size')->nullable();
            $table->boolean('is_initial')->default(0)->nullable();
            $table->boolean('is_final')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
