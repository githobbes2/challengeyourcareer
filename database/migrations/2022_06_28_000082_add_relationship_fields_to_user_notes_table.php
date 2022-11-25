<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUserNotesTable extends Migration
{
    public function up()
    {
        Schema::table('user_notes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_6880890')->references('id')->on('users');
            $table->unsignedBigInteger('session_user_id')->nullable();
            $table->foreign('session_user_id', 'session_user_fk_6880921')->references('id')->on('session_users');
        });
    }
}
