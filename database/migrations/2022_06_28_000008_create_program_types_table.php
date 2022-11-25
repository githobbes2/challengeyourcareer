<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramTypesTable extends Migration
{
    public function up()
    {
        Schema::create('program_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('outplacement')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
