<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    protected $fillable = [
        'logo',
        'titre',
        'user_id',
        'description',
        'published',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stacks()
    {
        return $this->hasMany(Stack::class);
    }
}
