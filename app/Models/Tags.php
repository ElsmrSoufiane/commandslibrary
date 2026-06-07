<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    protected $fillable = [
        'name',
    ];

    public function communities()
    {
        return $this->belongsToMany(Community::class, 'tag_communities', 'tag_id', 'community_id')
            ->withTimestamps();
    }

    public function chatRooms()
    {
        return $this->belongsToMany(ChatRoom::class, 'chat_room_tag', 'tag_id', 'chat_room_id')
            ->withTimestamps();
    }
}
