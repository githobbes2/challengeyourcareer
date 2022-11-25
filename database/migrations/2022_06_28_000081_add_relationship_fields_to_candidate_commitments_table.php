<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCandidateCommitmentsTable extends Migration
{
    public function up()
    {
        Schema::table('candidate_commitments', function (Blueprint $table) {
            $table->unsignedBigInteger('candidate_id')->nullable();
            $table->foreign('candidate_id', 'candidate_fk_6880846')->references('id')->on('candidates');
            $table->unsignedBigInteger('session_user_id')->nullable();
            $table->foreign('session_user_id', 'session_user_fk_6880847')->references('id')->on('session_users');
            $table->unsignedBigInteger('development_area_id')->nullable();
            $table->foreign('development_area_id', 'development_area_fk_7078755')->references('id')->on('development_areas');
        });
    }
}
