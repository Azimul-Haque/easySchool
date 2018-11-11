<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
  public function users()
  {
      return $this->hasMany('App\User');
  }

  public function students()
  {
      return $this->hasMany('App\Student');
  }
  
  public function admissions()
  {
      return $this->hasMany('App\Admission');
  }

  protected $fillable = ['name', 'eiin', 'established', 'address', 'currentsession', 'classes', 'isadmissionon', 'isresultpublished', 'due', 'currentexam', 'monogram'];
}
