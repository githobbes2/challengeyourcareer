<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->date('birthday')->nullable();
            $table->string('government_number')->nullable();
            $table->string('passport')->nullable();
            $table->boolean('enable_challenge_card')->default(0)->nullable();
            $table->string('social_linkedin')->nullable();
            $table->datetime('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();
            $table->datetime('last_login')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
