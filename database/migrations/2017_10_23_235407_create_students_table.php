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
            $table->string('student_id', 15)->unique();

            $table->integer('roll')->nullable();

            $table->integer('class');
            $table->integer('section');
            $table->string('name_bangla');
            $table->string('name');
            $table->string('father');
            $table->string('mother');
            $table->string('fathers_occupation');
            $table->string('mothers_occupation');
            $table->integer('yearly_income');
            $table->string('religion');
            $table->string('nationality');
            $table->string('blood_group');
            $table->datetime('dob');
            $table->datetime('admission_date');
            $table->string('gender', 10);
            $table->string('cocurricular');
            $table->integer('facility');
            $table->string('village');
            $table->string('post_office');
            $table->string('upazilla');
            $table->string('district');
            $table->string('contact');
            $table->string('contact_2');
            $table->string('previous_school');
            $table->string('previous_school_address');
            $table->string('pec_result');
            $table->string('image');
            
            $table->string('jsc_registration_no', 20)->nullable();
            $table->string('jsc_roll', 20)->nullable();
            $table->string('jsc_session', 10)->nullable();
            $table->string('jsc_result', 10)->nullable();
            $table->string('jsc_subject_codes')->nullable();
            $table->string('jsc_fourth_subject_code', 5)->nullable();

            $table->string('ssc_registration_no', 20)->nullable();
            $table->string('ssc_roll', 20)->nullable();
            $table->string('ssc_session', 10)->nullable();
            $table->string('ssc_result',10)->nullable();
            $table->string('ssc_subject_codes')->nullable();
            $table->string('ssc_fourth_subject_code', 5)->nullable();

            $table->string('session');
            $table->integer('payment');
            $table->string('remarks');
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
