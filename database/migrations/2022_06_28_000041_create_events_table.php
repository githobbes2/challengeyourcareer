<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->date('start_time')->nullable();
            $table->integer('duration')->nullable();
            $table->longText('description')->nullable();
            $table->integer('experience_points')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
