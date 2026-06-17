<?php

namespace App\Filament\User\Resources\Templates\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\RichEditor;

class TemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                  TextInput::make("title")->required(),
                  RichEditor::make("body")->required(),
            ]);
    }
}
