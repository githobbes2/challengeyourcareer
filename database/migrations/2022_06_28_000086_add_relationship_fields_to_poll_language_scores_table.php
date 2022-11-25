<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPollLanguageScoresTable extends Migration
{
    public function up()
    {
        Schema::table('poll_language_scores', function (Blueprint $table) {
            $table->unsignedBigInteger('language_id')->nullable();
            $table->foreign('language_id', 'language_fk_6886973')->references('id')->on('languages');
            $table->unsignedBigInteger('education_level_id')->nullable();
            $table->foreign('education_level_id', 'education_level_fk_6886974')->references('id')->on('education_levels');
        });
    }
}
