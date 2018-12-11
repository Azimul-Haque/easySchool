<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examsubject extends Model
{
    public function exam() {
        return $this->belongsTo('App\Exam');
    }

    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }
}
