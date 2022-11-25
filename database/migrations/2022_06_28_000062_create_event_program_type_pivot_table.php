<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventProgramTypePivotTable extends Migration
{
    public function up()
    {
        Schema::create('event_program_type', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id', 'event_id_fk_6886507')->references('id')->on('events')->onDelete('cascade');
            $table->unsignedBigInteger('program_type_id');
            $table->foreign('program_type_id', 'program_type_id_fk_6886507')->references('id')->on('program_types')->onDelete('cascade');
        });
    }
}
