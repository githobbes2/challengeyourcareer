<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollQuestionGroupPivotTable extends Migration
{
    public function up()
    {
        Schema::create('poll_question_group', function (Blueprint $table) {
            $table->unsignedBigInteger('poll_id');
            $table->foreign('poll_id', 'poll_id_fk_6886890')->references('id')->on('polls')->onDelete('cascade');
            $table->unsignedBigInteger('question_group_id');
            $table->foreign('question_group_id', 'question_group_id_fk_6886890')->references('id')->on('question_groups')->onDelete('cascade');
        });
    }
}
