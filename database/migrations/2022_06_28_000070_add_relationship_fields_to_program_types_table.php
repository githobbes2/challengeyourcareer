<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToProgramTypesTable extends Migration
{
    public function up()
    {
        Schema::table('program_types', function (Blueprint $table) {
            $table->unsignedBigInteger('session_types_id')->nullable();
            $table->foreign('session_types_id', 'session_types_fk_6886160')->references('id')->on('session_types');
        });
    }
}
