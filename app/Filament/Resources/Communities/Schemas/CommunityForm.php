<?php

namespace App\Filament\Resources\Communities\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CommunityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('logo')
                    ->label(__('Logo'))
                    ->directory('form-attachments')
                    ->visibility('public')
                    ->avatar(),
                TextInput::make('title')
                    ->label(__('Title'))
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label(__('Description'))
                    ->rows(5)
                    ->cols(20)
                    ->columnSpan('full'),
            ])
            ->columns(2);
    }
}
