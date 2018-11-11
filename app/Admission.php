<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
  public function school() {
      return $this->belongsTo('App\School');
  }

  //public $fillable = ['school_id', 'application_id', 'name_bangla', 'name', 'father','mother', 'nationality', 'gender', 'dob', 'address','contact','session', 'class','image', 'payment'];
}
