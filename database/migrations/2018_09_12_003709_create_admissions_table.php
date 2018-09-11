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
            $table->integer('school_id');
            $table->integer('application_id');
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
        Schema::drop('admissions');
    }
}
