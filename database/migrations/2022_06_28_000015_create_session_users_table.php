<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionUsersTable extends Migration
{
    public function up()
    {
        Schema::create('session_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('attendance')->default(0)->nullable();
            $table->longText('notes')->nullable();
            $table->integer('score')->nullable();
            $table->longText('score_feedback')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
