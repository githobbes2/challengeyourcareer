<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToJobOffersTable extends Migration
{
    public function up()
    {
        Schema::table('job_offers', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_6757968')->references('id')->on('users');
            $table->unsignedBigInteger('candidate_id')->nullable();
            $table->foreign('candidate_id', 'candidate_fk_7079012')->references('id')->on('candidates');
            $table->unsignedBigInteger('program_id')->nullable();
            $table->foreign('program_id', 'program_fk_6758006')->references('id')->on('programs');
            $table->unsignedBigInteger('recruiter_type_id')->nullable();
            $table->foreign('recruiter_type_id', 'recruiter_type_fk_6757996')->references('id')->on('recruiter_types');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id', 'city_fk_6758002')->references('id')->on('cities');
            $table->unsignedBigInteger('educational_level_id')->nullable();
            $table->foreign('educational_level_id', 'educational_level_fk_6758079')->references('id')->on('education_levels');
            $table->unsignedBigInteger('professional_level_id')->nullable();
            $table->foreign('professional_level_id', 'professional_level_fk_6758080')->references('id')->on('professional_levels');
            $table->unsignedBigInteger('functional_area_id')->nullable();
            $table->foreign('functional_area_id', 'functional_area_fk_6758081')->references('id')->on('functional_areas');
            $table->unsignedBigInteger('skill_id')->nullable();
            $table->foreign('skill_id', 'skill_fk_6758083')->references('id')->on('skills');
            $table->unsignedBigInteger('industry_sector_id')->nullable();
            $table->foreign('industry_sector_id', 'industry_sector_fk_6758084')->references('id')->on('industry_sectors');
        });
    }
}
