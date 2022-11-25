<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultantSkillTagPivotTable extends Migration
{
    public function up()
    {
        Schema::create('consultant_skill_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('consultant_id');
            $table->foreign('consultant_id', 'consultant_id_fk_7076827')->references('id')->on('consultants')->onDelete('cascade');
            $table->unsignedBigInteger('skill_tag_id');
            $table->foreign('skill_tag_id', 'skill_tag_id_fk_7076827')->references('id')->on('skill_tags')->onDelete('cascade');
        });
    }
}
