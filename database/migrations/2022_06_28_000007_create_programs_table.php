<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('internal_name')->nullable();
            $table->string('individual');
            $table->string('invoice')->nullable();
            $table->string('reference')->nullable();
            $table->longText('internal_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
