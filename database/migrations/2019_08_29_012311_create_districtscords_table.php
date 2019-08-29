<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrictscordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districtscords', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_bangla');
            $table->float('cordx');
            $table->float('cordy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('districtscords');
    }
}
