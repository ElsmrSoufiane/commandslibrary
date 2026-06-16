<?php

namespace App\Filament\User\Resources\Emails\Pages;

use App\Filament\User\Resources\Emails\EmailResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEmail extends CreateRecord
{
    protected static string $resource = EmailResource::class;
}
