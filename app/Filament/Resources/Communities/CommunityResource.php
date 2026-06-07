<?php

namespace App\Filament\Resources\Communities;

use App\Filament\Resources\Communities\Pages\CreateCommunity;
use App\Filament\Resources\Communities\Pages\EditCommunity;
use App\Filament\Resources\Communities\Pages\ListCommunities;
use App\Filament\Resources\Communities\Pages\ViewCommunity;
use App\Filament\Resources\Communities\RelationManagers\AdminsRelationManager;
use App\Filament\Resources\Communities\RelationManagers\QuestionsRelationManager;
use App\Filament\Resources\Communities\RelationManagers\TagsRelationManager;
use App\Filament\Resources\Communities\Schemas\CommunityForm;
use App\Filament\Resources\Communities\Schemas\CommunityInfolist;
use App\Filament\Resources\Communities\Tables\CommunitiesTable;
use App\Models\Community;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommunityResource extends Resource
{
    protected static ?string $model = Community::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeEuropeAfrica;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationLabel = 'Communities';

    protected static ?string $modelLabel = 'Community';

    protected static ?string $pluralModelLabel = 'Communities';

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
        return CommunityForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CommunityInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CommunitiesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            TagsRelationManager::class,
            AdminsRelationManager::class,
            QuestionsRelationManager::class,
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'description'];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCommunities::route('/'),
            'create' => CreateCommunity::route('/create'),
            'view' => ViewCommunity::route('/{record}'),
            'edit' => EditCommunity::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
