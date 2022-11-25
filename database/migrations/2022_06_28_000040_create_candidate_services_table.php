<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateServicesTable extends Migration
{
    public function up()
    {
        Schema::create('candidate_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_service')->nullable();
            $table->boolean('attendance')->default(0)->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
