<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCandidateCurriculumsTable extends Migration
{
    public function up()
    {
        Schema::table('candidate_curriculums', function (Blueprint $table) {
            $table->unsignedBigInteger('candidate_id')->nullable();
            $table->foreign('candidate_id', 'candidate_fk_7078989')->references('id')->on('candidates');
        });
    }
}
