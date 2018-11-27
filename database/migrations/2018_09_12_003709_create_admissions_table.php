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
            $table->string('application_id', 15)->unique();
            $table->integer('application_roll')->unsigned();

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
            $table->string('gender', 10);
            $table->string('cocurricular');
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

            $table->string('session');
            $table->integer('payment');
            $table->string('application_status')->nullable();
            $table->string('mark_obtained')->nullable();
            $table->integer('merit_position')->nullable();
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
