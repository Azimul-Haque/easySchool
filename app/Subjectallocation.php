<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subjectallocation extends Model
{
    public $timestamps = false;
    
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function subject() {
        return $this->belongsTo('App\Subject');
    }
}
