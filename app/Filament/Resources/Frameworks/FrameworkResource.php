<?php

namespace App\Filament\Resources\Frameworks;

use App\Filament\Resources\Frameworks\Pages\CreateFramework;
use App\Filament\Resources\Frameworks\Pages\EditFramework;
use App\Filament\Resources\Frameworks\Pages\ListFrameworks;
use App\Filament\Resources\Frameworks\Pages\ViewFramework;
use App\Filament\Resources\Frameworks\Schemas\FrameworkForm;
use App\Filament\Resources\Frameworks\Schemas\FrameworkInfolist;
use App\Filament\Resources\Frameworks\Tables\FrameworksTable;
use App\Models\Framework;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FrameworkResource extends Resource
{
    protected static ?string $model = Framework::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCpuChip;

    protected static ?string $recordTitleAttribute = 'titre';

    public static function form(Schema $schema): Schema
    {
        return FrameworkForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FrameworkInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FrameworksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['titre', 'description']; 
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFrameworks::route('/'),
            'create' => CreateFramework::route('/create'),
            'view' => ViewFramework::route('/{record}'),
            'edit' => EditFramework::route('/{record}/edit'),
        ];
    }
}
