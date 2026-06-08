<?php

namespace App\Filament\Resources\Communities\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    protected static ?string $title = 'Questions';

    protected function isOwner()
    {
        return auth()->user()->isTheAdmin($this->getOwnerRecord());
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Questions');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label(__('Title'))
                    ->required()
                    ->maxLength(255),
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
                TextEntry::make('title')
                    ->label(__('Title')),
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
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable(),
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
                EditAction::make()->authorize(fn (Model $record) => auth()->user()->isQuestionWriter($record->id)),
                DeleteAction::make()->authorize(fn (Model $record) => auth()->user()->isQuestionWriter($record->id) || $this->isOwner()),
                Action::make('answer')
                    ->authorize(fn () => true)
                    ->label(__('Answer'))
                    ->icon('heroicon-m-chat-bubble-left-ellipsis')
                    ->modalHeading(__('Answer this question'))
                    ->form([
                        Textarea::make('body')
                            ->label(__('Body'))
                            ->required()
                            ->rows(4),
                    ])
                    ->action(function (Model $record, array $data): void {
                        $record->answers()->create([
                            'body' => $data['body'],
                            'user_id' => auth()->id(),
                        ]);
                    })
                    ->modalSubmitActionLabel(__('Submit Answer'))
                    ->successNotificationTitle(__('Answer added successfully')),
                Action::make('viewAnswers')
                    ->authorize(fn () => true)
                    ->label(__('Answers'))
                    ->icon('heroicon-m-eye')
                    ->modalHeading(fn (Model $record): string => __('Answers for :title', ['title' => $record->title]))
                    ->modalContent(fn (Model $record) => view('filament.modals.question-answers', [
                        'answers' => $record->answers()->with('user')->latest()->get(),
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel(__('Close')),
            ]);
    }
}
