<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollAgeScoreProfessionalLevelPivotTable extends Migration
{
    public function up()
    {
        Schema::create('poll_age_score_professional_level', function (Blueprint $table) {
            $table->unsignedBigInteger('poll_age_score_id');
            $table->foreign('poll_age_score_id', 'poll_age_score_id_fk_6886966')->references('id')->on('poll_age_scores')->onDelete('cascade');
            $table->unsignedBigInteger('professional_level_id');
            $table->foreign('professional_level_id', 'professional_level_id_fk_6886966')->references('id')->on('professional_levels')->onDelete('cascade');
        });
    }
}
