<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatRoom extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'logo',
        'user_id',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'chat_room_user')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'chat_room_tag', 'chat_room_id', 'tag_id')
            ->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
