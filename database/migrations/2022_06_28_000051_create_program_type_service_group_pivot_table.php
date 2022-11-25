<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramTypeServiceGroupPivotTable extends Migration
{
    public function up()
    {
        Schema::create('program_type_service_group', function (Blueprint $table) {
            $table->unsignedBigInteger('program_type_id');
            $table->foreign('program_type_id', 'program_type_id_fk_6886161')->references('id')->on('program_types')->onDelete('cascade');
            $table->unsignedBigInteger('service_group_id');
            $table->foreign('service_group_id', 'service_group_id_fk_6886161')->references('id')->on('service_groups')->onDelete('cascade');
        });
    }
}
