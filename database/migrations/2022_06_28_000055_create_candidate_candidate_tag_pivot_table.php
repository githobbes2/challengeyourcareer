<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateCandidateTagPivotTable extends Migration
{
    public function up()
    {
        Schema::create('candidate_candidate_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('candidate_id');
            $table->foreign('candidate_id', 'candidate_id_fk_6758467')->references('id')->on('candidates')->onDelete('cascade');
            $table->unsignedBigInteger('candidate_tag_id');
            $table->foreign('candidate_tag_id', 'candidate_tag_id_fk_6758467')->references('id')->on('candidate_tags')->onDelete('cascade');
        });
    }
}
