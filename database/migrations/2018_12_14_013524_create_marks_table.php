<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_id');
            $table->integer('exam_id');
            $table->integer('subject_id');
            $table->integer('student_id');
            $table->integer('class');
            $table->integer('section');
            $table->integer('roll');
            $table->string('written');
            $table->string('mcq');
            $table->string('practical');
            $table->string('ca');
            $table->string('total_percentage');
            $table->string('total');
            $table->string('grade_point');
            $table->string('gpa');
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
        Schema::drop('marks');
    }
}
