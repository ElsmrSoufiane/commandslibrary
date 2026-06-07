<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Command extends Model
{
    use SoftDeletes;

    public function technology()
    {
        return $this->belongsTo(Technology::class);
    }

    protected $fillable = [
        'command',
        'user_id',
        'description',
        'order',
        'technology_id',
    ];
}
