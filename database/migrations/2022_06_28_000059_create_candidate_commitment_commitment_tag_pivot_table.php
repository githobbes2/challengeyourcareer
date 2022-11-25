<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateCommitmentCommitmentTagPivotTable extends Migration
{
    public function up()
    {
        Schema::create('candidate_commitment_commitment_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('candidate_commitment_id');
            $table->foreign('candidate_commitment_id', 'candidate_commitment_id_fk_6880860')->references('id')->on('candidate_commitments')->onDelete('cascade');
            $table->unsignedBigInteger('commitment_tag_id');
            $table->foreign('commitment_tag_id', 'commitment_tag_id_fk_6880860')->references('id')->on('commitment_tags')->onDelete('cascade');
        });
    }
}
