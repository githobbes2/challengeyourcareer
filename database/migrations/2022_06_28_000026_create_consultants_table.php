<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultantsTable extends Migration
{
    public function up()
    {
        Schema::create('consultants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('profile')->nullable();
            $table->longText('session_skills')->nullable();
            $table->boolean('challenge_card')->default(0)->nullable();
            $table->string('url_linkedin')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
