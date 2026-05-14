<?php

namespace App\Filament\Resources\Frameworks\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Hidden;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Filters\TrashedFilter;

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
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('description'),
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

                // ─── Manage Commands ───────────────────────────────────────────
                Action::make('manage_commands')
                    ->label(__('commands'))
                    ->icon('heroicon-o-command-line')
                    ->color('info')
                    ->modalHeading(fn ($record) => "Commands — {$record->name}")
                    ->modalWidth('3xl')
                    ->modalSubmitActionLabel('Save Changes')
                    ->fillForm(function ($record) {
                        $commands = $record->commands()
                            ->orderBy('order')
                            ->get(['id', 'command', 'description', 'order'])
                            ->map(fn ($c) => [
                                'id'          => $c->id,
                                'command'     => $c->command,
                                'description' => $c->description,
                                'order'       => $c->order,
                            ])
                            ->toArray();

                        return ['commands' => $commands];
                    })
                    ->form([
                        Repeater::make('commands')
                            ->label(__('commands'))
                            ->schema([
                                Hidden::make('id'),
                                TextInput::make('command')
                                    ->label(__('command'))
                                    ->required()
                                    ->maxLength(500)
                                    ->columnSpan(2)
                                    ->disabled(fn () => !$this->isOwner()),
                                TextInput::make('description')
                                    ->label('Description')
                                    ->maxLength(255)
                                    ->columnSpan(2)
                                    ->disabled(fn () => !$this->isOwner()),
                            ])
                            ->columns(4)
                            ->reorderable()
                            ->reorderableWithDragAndDrop(fn () => $this->isOwner())
                            ->addable(fn () => $this->isOwner())
                            ->deletable(fn () => $this->isOwner())
                            ->cloneable(fn () => $this->isOwner())
                            ->collapsible()
                            ->itemLabel(fn (array $state) => $state['command'] ?? 'New Command')
                            ->defaultItems(0),
                    ])
                    ->modalSubmitAction(fn ($action) => $this->isOwner() ? $action : $action->hidden())
                    ->action(function (array $data, $record): void {
                        if (!$this->isOwner()) {
                            return;
                        }

                        DB::transaction(function () use ($data, $record) {
                            $existing = $record->commands()->pluck('id')->toArray();
                            $submitted = collect($data['commands'] ?? []);

                            $submittedIds = $submitted->pluck('id')->filter()->toArray();

                            // Delete removed commands
                            $record->commands()
                                ->whereIn('id', array_diff($existing, $submittedIds))
                                ->delete();

                            // Update or create commands
                            foreach ($submitted as $index => $item) {
                                if (empty($item['command'])) {
                                    continue;
                                }

                                $payload = [
                                    'command'     => $item['command'],
                                    'description' => $item['description'] ?? null,
                                    'order'       => $index,
                                ];

                                if (!empty($item['id'])) {
                                    $record->commands()->where('id', $item['id'])->update($payload);
                                } else {
                                    $record->commands()->create($payload);
                                }
                            }
                        });
                    })
                    ->successNotificationTitle(__('Commands saved!')),

                // ─── Copy Commands to Clipboard ────────────────────────────────
                Action::make(__('copy_commands'))
                    ->label(__('Copy'))
                    ->icon('heroicon-o-clipboard')
                    ->color('warning')
                    ->tooltip(__('Copy all commands to clipboard'))
                    ->action(function ($record) {
                        $commandsText = $record->commands()
                            ->orderBy('order')
                            ->pluck('command')
                            ->join("\n");

                        $this->js("
                            const text = " . json_encode($commandsText) . ";
                            navigator.clipboard.writeText(text).catch(() => {
                                const el = document.createElement('textarea');
                                el.value = text;
                                document.body.appendChild(el);
                                el.select();
                                document.execCommand('copy');
                                document.body.removeChild(el);
                            });
                        ");
                    })
                    ->after(function (Action $action) {
                        $action->successNotificationTitle(__('Commands copied to clipboard!'))
                            ->sendSuccessNotification();
                    }),

                DissociateAction::make(),
                DeleteAction::make()->authorize(fn () => $this->isOwner()),
                ForceDeleteAction::make(),
                RestoreAction::make(),
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