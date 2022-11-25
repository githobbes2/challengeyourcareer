<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->datetime('start_time');
            $table->integer('duration');
            $table->string('location')->nullable();
            $table->string('status');
            $table->longText('description')->nullable();
            $table->longText('private_notes')->nullable();
            $table->integer('manager_score')->nullable();
            $table->integer('experience_points')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
