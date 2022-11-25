<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateProgramsTable extends Migration
{
    public function up()
    {
        Schema::create('candidate_programs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('program_start_date')->nullable();
            $table->date('program_end_date')->nullable();
            $table->date('relocation_date')->nullable();
            $table->string('relocation_company')->nullable();
            $table->longText('internal_notes')->nullable();
            $table->string('status', 5)->nullable()->default('0');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
