<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOfferLanguagePivotTable extends Migration
{
    public function up()
    {
        Schema::create('job_offer_language', function (Blueprint $table) {
            $table->unsignedBigInteger('job_offer_id');
            $table->foreign('job_offer_id', 'job_offer_id_fk_6758082')->references('id')->on('job_offers')->onDelete('cascade');
            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id', 'language_id_fk_6758082')->references('id')->on('languages')->onDelete('cascade');
        });
    }
}
