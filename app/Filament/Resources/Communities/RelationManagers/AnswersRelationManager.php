<?php

namespace App\Filament\Resources\Communities\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class AnswersRelationManager extends RelationManager
{
    protected static string $relationship = 'answers';

    protected static ?string $title = 'Answers';

    protected function isOwner()
    {
        return auth()->user()->isTheAdmin($this->getOwnerRecord());
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Answers');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('question_id')
                    ->label(__('Question'))
                    ->relationship('question', 'title')
                    ->searchable()
                    ->required(),
                Textarea::make('body')
                    ->label(__('Body'))
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('question.title')
                    ->label(__('Question')),
                TextEntry::make('body')
                    ->label(__('Body'))
                    ->columnSpanFull(),
                TextEntry::make('user.name')
                    ->label(__('User')),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('body')
            ->columns([
                TextColumn::make('question.title')
                    ->label(__('Question'))
                    ->searchable()
                    ->limit(50),
                TextColumn::make('body')
                    ->label(__('Body'))
                    ->searchable()
                    ->limit(80),
                TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(__('Created'))
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->authorize(fn () => true)
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['user_id'] = auth()->id();

                        return $data;
                    }),
            ])
            ->recordActions([
                ViewAction::make()->authorize(fn () => true),
                EditAction::make()->authorize(fn (Model $record) => auth()->user()->isAnswerWriter($record->id)),
                DeleteAction::make()->authorize(fn (Model $record) => auth()->user()->isAnswerWriter($record->id) || $this->isOwner()),
            ]);
    }
}
