<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateCommitmentsTable extends Migration
{
    public function up()
    {
        Schema::create('candidate_commitments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->boolean('complete')->default(0)->nullable();
            $table->date('completion_date')->nullable();
            $table->longText('note')->nullable();
            $table->longText('comments')->nullable();
            $table->integer('experience_points')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
