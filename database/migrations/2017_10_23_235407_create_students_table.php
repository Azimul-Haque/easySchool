<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_id')->unsigned();
            $table->string('application_id')->uniqe();
            $table->string('name_bangla');
            $table->string('name');
            $table->string('father');
            $table->string('mother');
            $table->string('nationality');
            $table->integer('gender');
            $table->datetime('dob');
            $table->text('address');
            $table->string('contact');
            $table->string('session');
            $table->integer('class');
            $table->string('section')->nullable();
            $table->integer('roll')->nullable();
            $table->string('image');
            $table->integer('payment');
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
         Schema::drop("students");
    }
}
