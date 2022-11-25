<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOfferJobOfferTagPivotTable extends Migration
{
    public function up()
    {
        Schema::create('job_offer_job_offer_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('job_offer_id');
            $table->foreign('job_offer_id', 'job_offer_id_fk_6758466')->references('id')->on('job_offers')->onDelete('cascade');
            $table->unsignedBigInteger('job_offer_tag_id');
            $table->foreign('job_offer_tag_id', 'job_offer_tag_id_fk_6758466')->references('id')->on('job_offer_tags')->onDelete('cascade');
        });
    }
}
