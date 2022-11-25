<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventCandidatesTable extends Migration
{
    public function up()
    {
        Schema::create('event_candidates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('attendance')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
