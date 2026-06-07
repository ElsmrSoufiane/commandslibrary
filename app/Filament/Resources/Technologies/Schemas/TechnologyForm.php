<?php

namespace App\Filament\Resources\Technologies\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TechnologyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('logo')
                    ->directory('form-attachments')
                    ->visibility('public')
                    ->avatar(),
                Toggle::make('published'),
                TextInput::make('titre')
                    ->required(),
                Textarea::make('description')
                    ->rows(5)
                    ->cols(20)
                    ->columnspan('full'),
            ])
            ->columns(2);
    }
}
