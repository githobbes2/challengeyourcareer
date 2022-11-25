<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyEventPivotTable extends Migration
{
    public function up()
    {
        Schema::create('company_event', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id', 'event_id_fk_6886508')->references('id')->on('events')->onDelete('cascade');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id', 'company_id_fk_6886508')->references('id')->on('companies')->onDelete('cascade');
        });
    }
}
