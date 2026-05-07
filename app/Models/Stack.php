<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stack extends Model
{
    use SoftDeletes;
    protected $fillable=[
        'name',
        'description',
        'framework_id',
    ];
    public function framework(){
        return $this->belongsTo(Framework::class);
    }
    public function commands(){
        return $this->hasMany(Command::class);
    }
}
