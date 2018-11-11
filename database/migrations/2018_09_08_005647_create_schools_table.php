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
            $table->string('name');
            $table->integer('eiin')->unique();
            $table->integer('sections')->unsigned();
            $table->integer('established');
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
