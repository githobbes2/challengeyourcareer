<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionSessionTypePivotTable extends Migration
{
    public function up()
    {
        Schema::create('question_session_type', function (Blueprint $table) {
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id', 'question_id_fk_6886934')->references('id')->on('questions')->onDelete('cascade');
            $table->unsignedBigInteger('session_type_id');
            $table->foreign('session_type_id', 'session_type_id_fk_6886934')->references('id')->on('session_types')->onDelete('cascade');
        });
    }
}
