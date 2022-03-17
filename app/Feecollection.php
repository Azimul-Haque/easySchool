<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feecollection extends Model
{
    public function student() {
        return $this->belongsTo('App\Student', 'student_id', 'student_id');
    }
}
