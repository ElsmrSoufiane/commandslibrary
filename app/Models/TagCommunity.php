<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagCommunity extends Model
{
    protected $fillable = [
        'tag_id',
        'community_id',
    ];

    public function tag()
    {
        return $this->belongsTo(Tags::class);
    }

    public function community()
    {
        return $this->belongsTo(Community::class);
    }
}
