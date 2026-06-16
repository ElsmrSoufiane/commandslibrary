<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Email extends Model
{
    use Notifiable;

    protected $fillable = [
        'email',
        'active',
        'token',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $email): void {
            $email->token = (string) Str::uuid();
        });
    }

    public function routeNotificationForMail(): string
    {
        return $this->email;
    }
}
