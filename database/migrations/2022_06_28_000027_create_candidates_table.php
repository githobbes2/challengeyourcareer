<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('address')->nullable();
            $table->string('postalcode')->nullable();
            $table->longText('profile')->nullable();
            $table->string('position')->nullable();
            $table->boolean('disability')->default(0)->nullable();
            $table->boolean('immigrant')->default(0)->nullable();
            $table->float('employability_score', 5, 2)->nullable();
            $table->date('employability_score_date')->nullable();
            $table->boolean('challenge_card')->default(0)->nullable();
            $table->longText('target_companies')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
