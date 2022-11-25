<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id', 'company_fk_6745792')->references('id')->on('companies');
            $table->unsignedBigInteger('system_language_id')->nullable();
            $table->foreign('system_language_id', 'system_language_fk_6880936')->references('id')->on('languages');
        });
    }
}
