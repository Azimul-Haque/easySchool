<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

  public function school() {
      return $this->belongsTo('App\School');
  }

  public function marks()
  {
      return $this->hasMany('App\Mark', 'student_id');
  }
  //public $fillable = ['name','class','roll','dob','father','mother','address','contact','session'];

}
