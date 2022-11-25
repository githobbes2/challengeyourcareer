<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSessionUsersTable extends Migration
{
    public function up()
    {
        Schema::table('session_users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_6745917')->references('id')->on('users');
            $table->unsignedBigInteger('session_id')->nullable();
            $table->foreign('session_id', 'session_fk_6745918')->references('id')->on('sessions');
        });
    }
}
