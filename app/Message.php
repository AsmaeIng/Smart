<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = ['id'];

    public function users()
	{
	    return $this->belongsToMany(User::class, 'user_message', 'message_id', 'sender_id')->withTimestamps();
	}

	public function sender()
	{
	    return $this->belongsToMany(User::class, 'user_message', 'message_id', 'sender_id')->withTimestamps();
	}

	public function getSenderAttribute()
	{
		return $this->sender()->first();
	}
}
