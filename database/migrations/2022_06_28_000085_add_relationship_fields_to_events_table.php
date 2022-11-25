<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEventsTable extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_6886503')->references('id')->on('users');
            $table->unsignedBigInteger('development_area_id')->nullable();
            $table->foreign('development_area_id', 'development_area_fk_7078730')->references('id')->on('development_areas');
        });
    }
}
