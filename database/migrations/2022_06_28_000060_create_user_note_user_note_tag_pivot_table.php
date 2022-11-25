<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserNoteUserNoteTagPivotTable extends Migration
{
    public function up()
    {
        Schema::create('user_note_user_note_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('user_note_id');
            $table->foreign('user_note_id', 'user_note_id_fk_6880892')->references('id')->on('user_notes')->onDelete('cascade');
            $table->unsignedBigInteger('user_note_tag_id');
            $table->foreign('user_note_tag_id', 'user_note_tag_id_fk_6880892')->references('id')->on('user_note_tags')->onDelete('cascade');
        });
    }
}
