<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Typelistes extends Model
{
    protected $table = 'typelistes';
    public $timestamps = false; 

    
     public function user()
    {
        return $this->belongsTo('App\User', 'users_id')->withTrashed();
    }
}
