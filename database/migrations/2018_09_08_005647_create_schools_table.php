<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token')->unique();
            $table->string('name');
            $table->string('name_bangla');
            $table->integer('eiin')->unique();
            $table->integer('school_code');
            $table->string('contact');
            $table->integer('sections')->unsigned();
            $table->integer('section_type')->unsigned();
            $table->integer('established');
            $table->string('district');
            $table->string('upazilla');
            $table->text('address');
            $table->integer('currentsession');
            $table->integer('admission_session');
            $table->string('classes');
            $table->integer('isadmissionon');
            $table->integer('isresultpublished');
            $table->integer('due');
            $table->string('currentexam')->nullable();
            $table->string('payment_method')->nullable();
            $table->integer('admission_form_fee')->nullable();
            $table->integer('admission_total_marks')->nullable();
            $table->integer('admission_bangla_mark')->nullable();
            $table->integer('admission_english_mark')->nullable();
            $table->integer('admission_math_mark')->nullable();
            $table->integer('admission_gk_mark')->nullable();
            $table->integer('admission_pass_mark')->nullable();
            $table->datetime('admission_start_date')->nullable();
            $table->datetime('admission_end_date')->nullable();
            $table->datetime('admission_test_datetime')->nullable();
            $table->datetime('admission_test_result')->nullable();
            $table->datetime('admission_final_start')->nullable();
            $table->datetime('admission_final_end')->nullable();
            $table->datetime('admit_card_texts')->nullable();
            $table->string('headmaster_sign')->nullable();
            $table->string('monogram')->nullable();
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
        Schema::drop('schools');
    }
}
