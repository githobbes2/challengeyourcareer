<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateCompanyPivotTable extends Migration
{
    public function up()
    {
        Schema::create('candidate_company', function (Blueprint $table) {
            $table->unsignedBigInteger('candidate_id');
            $table->foreign('candidate_id', 'candidate_id_fk_6758439')->references('id')->on('candidates')->onDelete('cascade');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id', 'company_id_fk_6758439')->references('id')->on('companies')->onDelete('cascade');
        });
    }
}
