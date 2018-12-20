<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    public function student() {
        return $this->belongsTo('App\Student', 'student_id', 'student_id');
    }

    public function subject() {
        return $this->belongsTo('App\Subject');
    }
}
