<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

  public function school() {
      return $this->belongsTo('App\School');
  }
  //public $fillable = ['name','class','roll','dob','father','mother','address','contact','session'];

}
