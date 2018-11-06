<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_id')->unsigned();
            $table->integer('application_id')->unique();
            $table->integer('application_roll')->unsigned();
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
            $table->integer('section');
            $table->string('image');
            $table->integer('payment');
            $table->integer('application_status ')->nullable();
            $table->string('mark_obtained ')->nullable();
            $table->integer('merit_position ')->unsigned(->nullable();
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
        Schema::drop('admissions');
    }
}
