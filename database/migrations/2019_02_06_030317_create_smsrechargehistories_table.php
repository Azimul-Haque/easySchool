<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsrechargehistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smsrechargehistories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_id');
            $table->integer('smscount');
            $table->string('tk');
            $table->string('trx_id');
            $table->integer('activation_status');
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
        Schema::drop('smsrechargehistories');
    }
}
