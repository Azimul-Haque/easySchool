<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectallocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjectallocations', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('school_id')->unsigned();
            $table->integer('exam_id')->unsigned();
            $table->integer('subject_id')->unsigned();
            $table->integer('class');
            $table->integer('section');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('subjectallocations');
    }
}
