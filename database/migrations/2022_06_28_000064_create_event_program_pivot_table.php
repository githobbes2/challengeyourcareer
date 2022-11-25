<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventProgramPivotTable extends Migration
{
    public function up()
    {
        Schema::create('event_program', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id', 'event_id_fk_6886509')->references('id')->on('events')->onDelete('cascade');
            $table->unsignedBigInteger('program_id');
            $table->foreign('program_id', 'program_id_fk_6886509')->references('id')->on('programs')->onDelete('cascade');
        });
    }
}
