<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionScoreSessionTypeTable extends Migration
{
    public function up()
    {
        Schema::create('question_score_session_type', function (Blueprint $table) {
            $table->unsignedInteger('question_id');
            $table->foreign('question_id', 'question_id_fk_1709163')->references('id')->on('questions')->onDelete('cascade');
            $table->unsignedInteger('session_type_id');
            $table->foreign('session_type_id', 'session_type_id_fk_1709163')->references('id')->on('session_types')->onDelete('cascade');
            $table->unsignedSmallInteger('score');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_score_session_type');
    }
}
