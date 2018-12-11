<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    public function examsubjects()
    {
        return $this->hasMany('App\Examsubject');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
