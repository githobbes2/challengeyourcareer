<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCandidateServicesTable extends Migration
{
    public function up()
    {
        Schema::table('candidate_services', function (Blueprint $table) {
            $table->unsignedBigInteger('candidate_id')->nullable();
            $table->foreign('candidate_id', 'candidate_fk_6886362')->references('id')->on('candidates');
            $table->unsignedBigInteger('service_item_id')->nullable();
            $table->foreign('service_item_id', 'service_item_fk_6886363')->references('id')->on('service_items');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_6886365')->references('id')->on('users');
            $table->unsignedBigInteger('candidate_program_id')->nullable();
            $table->foreign('candidate_program_id', 'candidate_program_fk_6886368')->references('id')->on('candidate_programs');
            $table->unsignedBigInteger('session_user_id')->nullable();
            $table->foreign('session_user_id', 'session_user_fk_6886369')->references('id')->on('session_users');
        });
    }
}
