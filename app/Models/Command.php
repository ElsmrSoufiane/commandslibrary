<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    protected $fillable=[
        'command',
        'user_id',
        'framework_id',
    ];
}
