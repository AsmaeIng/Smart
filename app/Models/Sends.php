<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sends extends Model
{
    protected $table = 'sends';
    public $timestamps = false; 

    
     public function user()
    {
        return $this->belongsTo('App\User', 'users_id')->withTrashed();
    }
}
