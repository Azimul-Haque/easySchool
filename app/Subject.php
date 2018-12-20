<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public $timestamps = false;

    public function examsubject() {
        return $this->hasMany('App\Examsubject');
    }

    public function subjectallocation() {
        return $this->hasMany('App\Subjectallocation');
    }

    public function marks() {
        return $this->hasMany('App\Mark');
    }
}
