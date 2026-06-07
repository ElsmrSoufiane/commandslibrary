<?php

namespace App\Filament\Resources\Technologies;

use App\Filament\Resources\Technologies\Pages\CreateTechnology;
use App\Filament\Resources\Technologies\Pages\EditTechnology;
use App\Filament\Resources\Technologies\Pages\ListTechnologies;
use App\Filament\Resources\Technologies\Pages\ViewTechnology;
use App\Filament\Resources\Technologies\RelationManagers\TechnologyRelationManager;
use App\Filament\Resources\Technologies\Schemas\TechnologyForm;
use App\Filament\Resources\Technologies\Schemas\TechnologyInfolist;
use App\Filament\Resources\Technologies\Tables\TechnologiesTable;
use App\Models\Technology;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TechnologyResource extends Resource
{
    protected static ?string $model = Technology::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCpuChip;

    protected static ?string $recordTitleAttribute = 'titre';

    // Add these for translation support
    protected static ?string $navigationLabel = 'Technologies';

    protected static ?string $modelLabel = 'Technology';

    protected static ?string $pluralModelLabel = 'Technologies';

    public static function getNavigationLabel(): string
    {
        return __(static::$navigationLabel);
    }

    public static function getModelLabel(): string
    {
        return __(static::$modelLabel);
    }

    public static function getPluralModelLabel(): string
    {
        return __(static::$pluralModelLabel);
    }

    public static function form(Schema $schema): Schema
    {
        return TechnologyForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TechnologyInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TechnologiesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            TechnologyRelationManager::class,
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['titre', 'description'];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTechnologies::route('/'),
            'create' => CreateTechnology::route('/create'),
            'view' => ViewTechnology::route('/{record}'),
            'edit' => EditTechnology::route('/{record}/edit'),
        ];
    }
}
