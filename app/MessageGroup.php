<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageGroup extends Model
{
    protected $guarded = ['id'];

    public function users()
	{
		return $this->belongsToMany(User::class, 'user_message_group', 'message_group_id', 'user_id')->withPivot('id', 'status')->withTimestamps();
	}

	public function messages()
	{
		return $this->belongsToMany(Message::class, 'user_message');
	}

	public function latest_message()
	{
		return $this->belongsToMany(Message::class, 'user_message');
	}

	public function scopeActive($query)
	{
		return $query->where('message_groups.status', 1);
	}

	public function getLatestMessageAttribute()
	{
		return $this->latest_message()->latest()->first();
	}
}
