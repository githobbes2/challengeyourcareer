<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionTemplateSessionTypePivotTable extends Migration
{
    public function up()
    {
        Schema::create('session_template_session_type', function (Blueprint $table) {
            $table->unsignedBigInteger('session_template_id');
            $table->foreign('session_template_id', 'session_template_id_fk_2547258')->references('id')->on('session_templates')->onDelete('cascade');
            $table->unsignedBigInteger('session_type_id');
            $table->foreign('session_type_id', 'session_type_id_fk_2547258')->references('id')->on('session_types')->onDelete('cascade');
            $table->integer('quantity');
            $table->integer('duration');
        });
    }
}
