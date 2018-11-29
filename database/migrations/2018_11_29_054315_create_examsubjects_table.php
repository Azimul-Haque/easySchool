<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examsubjects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_id');
            $table->integer('subject_id');
            $table->string('written');
            $table->string('written_pass_mark');
            $table->string('mcq');
            $table->string('mcq_pass_mark');
            $table->string('practical');
            $table->string('practical_pass_mark');
            $table->string('ca');
            $table->string('total_percentage');
            $table->string('total');
            $table->string('pass_mark');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('examsubjects');
    }
}
