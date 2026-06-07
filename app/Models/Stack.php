<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stack extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'technology_id',
    ];

    public function technology()
    {
        return $this->belongsTo(Technology::class);
    }

    public function commands()
    {
        return $this->hasMany(Command::class);
    }
}
