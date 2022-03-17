<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeecollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feecollections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_id');
            $table->integer('class');
            $table->string('session');
            $table->integer('section');
            $table->integer('roll');
            $table->string('student_id', 15);
            $table->string('fee_attribute');
            $table->string('fee_value');
            // $table->string('admissio_session_fee');
            // $table->string('annual_sports_cultural');
            // $table->string('last_year_due');
            // $table->string('exam_fee');
            // $table->string('full_half_free_form');
            // $table->string('3_6_8_12_fee');
            // $table->string('jsc_ssc_form_fee');
            // $table->string('certificate_fee');
            // $table->string('scout_fee');
            // $table->string('develoment_donation');
            // $table->string('other_fee');
            $table->string('collector');
            $table->date('collection_date');
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
        Schema::drop('feecollections');
    }
}
