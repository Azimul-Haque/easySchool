<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    public $fillable = ['name','class','roll','dob','father','mother','address','contact','session'];

}
