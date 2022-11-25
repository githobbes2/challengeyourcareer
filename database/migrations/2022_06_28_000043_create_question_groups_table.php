<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('question_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('order')->nullable();
            $table->integer('weight')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
