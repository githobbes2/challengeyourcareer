<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramTypeSessionTypePivotTable extends Migration
{
    public function up()
    {
        Schema::create('program_type_session_type', function (Blueprint $table) {
            $table->unsignedBigInteger('program_type_id');
            $table->foreign('program_type_id', 'program_type_id_fk_7076764')->references('id')->on('program_types')->onDelete('cascade');
            $table->unsignedBigInteger('session_type_id');
            $table->foreign('session_type_id', 'session_type_id_fk_7076764')->references('id')->on('session_types')->onDelete('cascade');
        });
    }
}
