<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagePollCandidatePivotTable extends Migration
{
    public function up()
    {
        Schema::create('language_poll_candidate', function (Blueprint $table) {
            $table->unsignedBigInteger('poll_candidate_id');
            $table->foreign('poll_candidate_id', 'poll_candidate_id_fk_7078955')->references('id')->on('poll_candidates')->onDelete('cascade');
            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id', 'language_id_fk_7078955')->references('id')->on('languages')->onDelete('cascade');
        });
    }
}
