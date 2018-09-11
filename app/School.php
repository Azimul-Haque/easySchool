<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
  public function users()
  {
      return $this->hasMany('App\User');
  }
  
  public function admissions()
  {
      return $this->hasMany('App\Admission');
  }

  protected $fillable = ['name', 'eiin', 'address', 'currentsession', 'classes', 'isadmissionon', 'isresultpublished', 'due', 'currentexam', 'monogram'];
}
