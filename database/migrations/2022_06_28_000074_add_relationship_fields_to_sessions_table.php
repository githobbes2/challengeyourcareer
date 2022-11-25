<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSessionsTable extends Migration
{
    public function up()
    {
        Schema::table('sessions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_6758265')->references('id')->on('users');
            $table->unsignedBigInteger('session_type_id')->nullable();
            $table->foreign('session_type_id', 'session_type_fk_6745912')->references('id')->on('session_types');
            $table->unsignedBigInteger('program_id')->nullable();
            $table->foreign('program_id', 'program_fk_7076786')->references('id')->on('programs');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id', 'company_fk_7076787')->references('id')->on('companies');
            $table->unsignedBigInteger('development_area_id')->nullable();
            $table->foreign('development_area_id', 'development_area_fk_7078703')->references('id')->on('development_areas');
        });
    }
}
