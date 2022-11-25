<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCompaniesTable extends Migration
{
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->unsignedBigInteger('industry_sector_id')->nullable();
            $table->foreign('industry_sector_id', 'industry_sector_fk_6758549')->references('id')->on('industry_sectors');
        });
    }
}
