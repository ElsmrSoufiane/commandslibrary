<?php

namespace App\Filament\Resources\Frameworks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Group;

class FrameworkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('logo')
                    ->directory('form-attachments')
                    ->visibility('public')
                    ->avatar(),
                TextInput::make('titre')
                    ->required(),
                Textarea::make('description')
                ->rows(5)
                ->cols(20)
                ->columnspan('full')
                ,
            ])
            ->columns(2)
            ;
    }
}
