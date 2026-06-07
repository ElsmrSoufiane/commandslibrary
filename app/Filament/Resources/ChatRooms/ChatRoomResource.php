<?php

namespace App\Filament\Resources\ChatRooms;

use App\Filament\Resources\ChatRooms\Pages\CreateChatRoom;
use App\Filament\Resources\ChatRooms\Pages\EditChatRoom;
use App\Filament\Resources\ChatRooms\Pages\ListChatRooms;
use App\Filament\Resources\ChatRooms\Pages\ViewChatRoom;
use App\Filament\Resources\ChatRooms\RelationManagers\MembersRelationManager;
use App\Filament\Resources\ChatRooms\RelationManagers\TagsRelationManager;
use App\Filament\Resources\ChatRooms\Schemas\ChatRoomForm;
use App\Filament\Resources\ChatRooms\Schemas\ChatRoomInfolist;
use App\Filament\Resources\ChatRooms\Tables\ChatRoomsTable;
use App\Models\ChatRoom;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChatRoomResource extends Resource
{
    protected static ?string $model = ChatRoom::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationLabel = 'Chat Rooms';

    protected static ?string $modelLabel = 'Chat Room';

    protected static ?string $pluralModelLabel = 'Chat Rooms';

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
        return ChatRoomForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ChatRoomInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ChatRoomsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            TagsRelationManager::class,
            MembersRelationManager::class,
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'description'];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListChatRooms::route('/'),
            'create' => CreateChatRoom::route('/create'),
            'view' => ViewChatRoom::route('/{record}'),
            'edit' => EditChatRoom::route('/{record}/edit'),
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
