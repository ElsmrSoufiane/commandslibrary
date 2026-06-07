<?php

namespace App\Filament\Resources\ChatRooms\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DetachAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    protected static ?string $title = 'Members';

    protected function isOwner()
    {
        return auth()->user()->isChatRoomAdmin($this->getOwnerRecord());
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Members');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('role')
                    ->label(__('Role'))
                    ->options([
                        'member' => 'Member',
                        'admin' => 'Admin',
                    ])
                    ->default('member')
                    ->required(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label(__('User')),
                TextEntry::make('pivot.role')
                    ->label(__('Role'))
                    ->badge(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label(__('User'))
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable(),
                TextColumn::make('pivot.role')
                    ->label(__('Role'))
                    ->badge()
                    ->color(fn ($state) => $state === 'admin' ? 'primary' : 'gray'),
                TextColumn::make('created_at')
                    ->label(__('Joined'))
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->headerActions([
                AttachAction::make()
                    ->authorize(fn () => $this->isOwner())
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Select::make('role')
                            ->label(__('Role'))
                            ->options([
                                'member' => 'Member',
                                'admin' => 'Admin',
                            ])
                            ->default('member')
                            ->required(),
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()->authorize(fn () => $this->isOwner()),
                DetachAction::make()->authorize(fn () => $this->isOwner()),
                DeleteAction::make()->authorize(fn () => $this->isOwner()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
