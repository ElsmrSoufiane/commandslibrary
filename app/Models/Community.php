<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Community extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'logo',
    ];

    public function admins()
    {
        return $this->hasMany(CommunityAdmin::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'tag_communities', 'community_id', 'tag_id')
            ->withTimestamps();
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
