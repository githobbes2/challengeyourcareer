<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceGroupServiceItemPivotTable extends Migration
{
    public function up()
    {
        Schema::create('service_group_service_item', function (Blueprint $table) {
            $table->unsignedBigInteger('service_group_id');
            $table->foreign('service_group_id', 'service_group_id_fk_6886106')->references('id')->on('service_groups')->onDelete('cascade');
            $table->unsignedBigInteger('service_item_id');
            $table->foreign('service_item_id', 'service_item_id_fk_6886106')->references('id')->on('service_items')->onDelete('cascade');
        });
    }
}
