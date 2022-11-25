<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToProgramsTable extends Migration
{
    public function up()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->unsignedBigInteger('program_type_id')->nullable();
            $table->foreign('program_type_id', 'program_type_fk_6745795')->references('id')->on('program_types');
            $table->unsignedBigInteger('session_template_id')->nullable();
            $table->foreign('session_template_id', 'session_template_fk_5649381')->references('id')->on('session_templates');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_6758254')->references('id')->on('users');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id', 'company_fk_6745796')->references('id')->on('companies');
            $table->unsignedBigInteger('session_template_id')->nullable();
            $table->foreign('session_template_id', 'session_template_fk_7076896')->references('id')->on('session_templates');
            $table->unsignedBigInteger('service_group_id');
            $table->foreign('service_group_id', 'service_group_id_fk_3028741')->references('id')->on('service_groups')->onDelete('cascade');
        });
    }
}
