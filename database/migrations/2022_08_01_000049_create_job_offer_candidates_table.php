<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOfferCandidatesTable extends Migration
{
    public function up()
    {
        Schema::create('job_offer_candidates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status')->nullable();
            $table->boolean('is_favorite')->default(0)->nullable();
            $table->boolean('request_mediation')->default(0)->nullable();
            $table->string('mediation_status')->nullable();
            $table->longText('mediation_notes')->nullable();
            $table->longText('mediation_private_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
