<?php

namespace App\Filament\Resources\Communities\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class AdminsRelationManager extends RelationManager
{
    protected static string $relationship = 'admins';

    protected static ?string $title = 'Admins';

    protected function isOwner()
    {
        return auth()->user()->isTheAdmin($this->getOwnerRecord());
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Admins');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label(__('User'))
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required()
                    ->unique(
                        table: 'community_admins',
                        column: 'user_id',
                        modifyRuleUsing: fn ($rule) => $rule->where('community_id', $this->getOwnerRecord()->id),
                        ignoreRecord: true,
                    ),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label(__('User')),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user.name')
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchable(),
                TextColumn::make('user.email')
                    ->label(__('Email'))
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(__('Created'))
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()->authorize(fn () => $this->isOwner()),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()->authorize(fn () => $this->isOwner()),
                DeleteAction::make()->authorize(fn () => $this->isOwner()),
            ]);
    }
}
