<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_id');
            $table->string('name');
            $table->string('exam_code', 10)->unique();
            $table->integer('exam_session');
            $table->datetime('exam_start_date');
            $table->datetime('exam_end_date');
            $table->string('total_subjects');
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
        Schema::drop('exams');
    }
}
