<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCandidateProgramsTable extends Migration
{
    public function up()
    {
        Schema::table('candidate_programs', function (Blueprint $table) {
            $table->unsignedBigInteger('candidate_id')->nullable();
            $table->foreign('candidate_id', 'candidate_fk_6758469')->references('id')->on('candidates');
            $table->unsignedBigInteger('program_id')->nullable();
            $table->foreign('program_id', 'program_fk_6758470')->references('id')->on('programs');
            $table->unsignedBigInteger('relocation_company_id')->nullable();
            $table->foreign('relocation_company_id', 'relocation_company_fk_6758545')->references('id')->on('companies');
            $table->unsignedBigInteger('functional_area_id')->nullable();
            $table->foreign('functional_area_id', 'functional_area_fk_6758546')->references('id')->on('functional_areas');
            $table->unsignedBigInteger('profesional_level_id')->nullable();
            $table->foreign('profesional_level_id', 'profesional_level_fk_6758547')->references('id')->on('professional_levels');
            $table->unsignedBigInteger('industry_sector_id')->nullable();
            $table->foreign('industry_sector_id', 'industry_sector_fk_6758548')->references('id')->on('industry_sectors');
        });
    }
}
