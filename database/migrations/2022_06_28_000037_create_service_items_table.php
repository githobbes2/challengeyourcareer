<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceItemsTable extends Migration
{
    public function up()
    {
        Schema::create('service_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('objective')->nullable();
            $table->string('phase')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
