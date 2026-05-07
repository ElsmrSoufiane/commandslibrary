<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{   
    use SoftDeletes;

    public function framework(){
        return $this->belongsTo(Framework::class);
    }
    protected $fillable=[
        'command',
        'user_id',
        'description',
        'order',
        'framework_id',
    ];
}
