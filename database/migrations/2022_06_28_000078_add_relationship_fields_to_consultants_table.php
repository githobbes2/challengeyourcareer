<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToConsultantsTable extends Migration
{
    public function up()
    {
        Schema::table('consultants', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_6758305')->references('id')->on('users');
            $table->unsignedBigInteger('consultant_type_id')->nullable();
            $table->foreign('consultant_type_id', 'consultant_type_fk_6758306')->references('id')->on('consultant_types');
            $table->unsignedBigInteger('office_id')->nullable();
            $table->foreign('office_id', 'office_fk_6758307')->references('id')->on('offices');
        });
    }
}
