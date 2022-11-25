<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateSkillPivotTable extends Migration
{
    public function up()
    {
        Schema::create('candidate_skill', function (Blueprint $table) {
            $table->unsignedBigInteger('candidate_id');
            $table->foreign('candidate_id', 'candidate_id_fk_6758335')->references('id')->on('candidates')->onDelete('cascade');
            $table->unsignedBigInteger('skill_id');
            $table->foreign('skill_id', 'skill_id_fk_6758335')->references('id')->on('skills')->onDelete('cascade');
        });
    }
}
