<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionTypesTable extends Migration
{
    public function up()
    {
        Schema::create('session_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->boolean('score_required')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
