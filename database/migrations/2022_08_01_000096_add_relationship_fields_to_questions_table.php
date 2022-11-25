<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToQuestionsTable extends Migration
{
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->unsignedBigInteger('development_area_id')->nullable();
            $table->foreign('development_area_id', 'development_area_fk_7078794')->references('id')->on('development_areas');
        });
    }
}
