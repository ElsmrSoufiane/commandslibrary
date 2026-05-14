<?php

namespace App\Filament\Resources\Frameworks\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\TrashedFilter;
use  Webbingbrasil\FilamentCopyActions\Tables\Actions\CopyAction; 

class FrameworkRelationManager extends RelationManager
{
    protected static string $relationship = 'stacks';


    // Add this helper method
    protected function getOwnerUserId()
    {
        return $this->getOwnerRecord()->user_id;
    }

    // Add this to check if current user is the owner
    protected function isOwner()
    {
        return auth()->id() === $this->getOwnerUserId();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('description')
                    ->maxLength(255),
                Repeater::make('commands')
                ->relationship()
                ->schema([
                             TextInput::make('command')->required(),
                             TextInput::make('description'),
                        ])
                        ->columnSpanFull()
                        ->columns(2)
                        ->reorderableWithDragAndDrop()
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('description'),
                RepeatableEntry::make("commands")->schema([
                    TextEntry::make('command'),
                    TextEntry::make('description')
                        ])
                        ->columns(2)
                        ->columnSpanFull()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('commands_count')
                    ->counts('commands')
                    ->label(__('number of commands')),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                CreateAction::make()->authorize(fn () => $this->isOwner()),
                AssociateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()->authorize(fn () => $this->isOwner()),
                DeleteAction::make()->authorize(fn () => $this->isOwner()),
                CopyAction::make()
                    ->copyable(fn ($record) =>  $record->commands->pluck("command")->implode("\n"))
                    ->label(__("copy commands"))
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }
}