<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionQuestionGroupPivotTable extends Migration
{
    public function up()
    {
        Schema::create('question_question_group', function (Blueprint $table) {
            $table->unsignedBigInteger('question_group_id');
            $table->foreign('question_group_id', 'question_group_id_fk_7076806')->references('id')->on('question_groups')->onDelete('cascade');
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id', 'question_id_fk_7076806')->references('id')->on('questions')->onDelete('cascade');
        });
    }
}
