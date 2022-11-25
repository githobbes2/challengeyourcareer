<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateProgramCandidateProgramTagPivotTable extends Migration
{
    public function up()
    {
        Schema::create('candidate_program_candidate_program_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('candidate_program_id');
            $table->foreign('candidate_program_id', 'candidate_program_id_fk_6758481')->references('id')->on('candidate_programs')->onDelete('cascade');
            $table->unsignedBigInteger('candidate_program_tag_id');
            $table->foreign('candidate_program_tag_id', 'candidate_program_tag_id_fk_6758481')->references('id')->on('candidate_program_tags')->onDelete('cascade');
        });
    }
}
