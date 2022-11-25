<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCandidatesTable extends Migration
{
    public function up()
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_6758325')->references('id')->on('users');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by', 'created_by_fk_6758325')->references('id')->on('users');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id', 'company_fk_6758326')->references('id')->on('companies');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id', 'city_fk_6758330')->references('id')->on('cities');
            $table->unsignedBigInteger('education_level_id')->nullable();
            $table->foreign('education_level_id', 'education_level_fk_6758434')->references('id')->on('education_levels');
            $table->unsignedBigInteger('professional_level_id')->nullable();
            $table->foreign('professional_level_id', 'professional_level_fk_6758435')->references('id')->on('professional_levels');
            $table->unsignedBigInteger('functional_area_id')->nullable();
            $table->foreign('functional_area_id', 'functional_area_fk_6758436')->references('id')->on('functional_areas');
            $table->unsignedBigInteger('industry_sector_id')->nullable();
            $table->foreign('industry_sector_id', 'industry_sector_fk_6758437')->references('id')->on('industry_sectors');
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->foreign('gender_id', 'gender_fk_6758450')->references('id')->on('genders');
        });
    }
}
