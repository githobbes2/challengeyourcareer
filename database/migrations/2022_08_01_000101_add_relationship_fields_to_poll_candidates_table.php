<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPollCandidatesTable extends Migration
{
    public function up()
    {
        Schema::table('poll_candidates', function (Blueprint $table) {
            $table->unsignedBigInteger('poll_id')->nullable();
            $table->foreign('poll_id', 'poll_fk_7078947')->references('id')->on('polls');
            $table->unsignedBigInteger('candidate_id')->nullable();
            $table->foreign('candidate_id', 'candidate_fk_7078948')->references('id')->on('candidates');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id', 'city_fk_7078953')->references('id')->on('cities');
            $table->unsignedBigInteger('professional_level_id')->nullable();
            $table->foreign('professional_level_id', 'professional_level_fk_7078954')->references('id')->on('professional_levels');
            $table->unsignedBigInteger('educational_level_id')->nullable();
            $table->foreign('educational_level_id', 'educational_level_fk_7078956')->references('id')->on('education_levels');
            $table->unsignedBigInteger('functional_area_id')->nullable();
            $table->foreign('functional_area_id', 'functional_area_fk_7078957')->references('id')->on('functional_areas');
            $table->unsignedBigInteger('candidate_program_id')->nullable();
            $table->foreign('candidate_program_id', 'candidate_program_fk_7078959')->references('id')->on('candidate_programs');
        });
    }
}
