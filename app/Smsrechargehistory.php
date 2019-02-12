<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Smsrechargehistory extends Model
{
    public function school() {
        return $this->belongsTo('App\School');
    }
}
