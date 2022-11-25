<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToJobOfferCandidatesTable extends Migration
{
    public function up()
    {
        Schema::table('job_offer_candidates', function (Blueprint $table) {
            $table->unsignedBigInteger('job_offer_id')->nullable();
            $table->foreign('job_offer_id', 'job_offer_fk_7078649')->references('id')->on('job_offers');
            $table->unsignedBigInteger('candidate_id')->nullable();
            $table->foreign('candidate_id', 'candidate_fk_7078650')->references('id')->on('candidates');
            $table->unsignedBigInteger('curriculum_id')->nullable();
            $table->foreign('curriculum_id', 'curriculum_fk_7078996')->references('id')->on('candidate_curriculums');
        });
    }
}
