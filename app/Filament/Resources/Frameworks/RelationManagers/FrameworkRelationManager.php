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
                    ->label('Commands'),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                CreateAction::make()->authorize(fn () => auth()->user()->id == $this->getOwnerRecord()->user_id),
                AssociateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->authorize(fn () => auth()->user()->id == $this->getOwnerRecord()->user_id),

                // ─── Manage Commands ───────────────────────────────────────────
                Action::make('manage_commands')
                    ->label('Commands')
                    ->icon('heroicon-o-command-line')
                    ->color('info')
                    ->modalHeading(fn ($record) => "Commands — {$record->name}")
                    ->modalWidth('3xl')
                    ->modalSubmitActionLabel('Save Changes')
                    ->fillForm(function ($record) {
                        // Load existing commands ordered by `order` column
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
                            ->label('')
                            ->schema([
                                Hidden::make('id'),
                                TextInput::make('command')
                                    ->label('Command')
                                    ->required()
                                    ->maxLength(500)
                                    ->columnSpan(2),
                                TextInput::make('description')
                                    ->label('Description')
                                    ->maxLength(255)
                                    ->columnSpan(2),
                            ])
                            ->columns(4)
                            ->reorderable()          // drag-handle to reorder
                            ->reorderableWithDragAndDrop()
                            ->addActionLabel('Add Command')
                            ->cloneable()            // clone a command row
                            ->collapsible()          // collapse rows to save space
                            ->itemLabel(fn (array $state) => $state['command'] ?? 'New Command')
                            ->defaultItems(0),
                    ])
                    ->action(function (array $data, $record): void {
                        DB::transaction(function () use ($data, $record) {
                            $existing = $record->commands()->pluck('id')->toArray();
                            $submitted = collect($data['commands']);

                            // IDs present in form = keep/update; absent = delete
                            $submittedIds = $submitted
                                ->pluck('id')
                                ->filter()
                                ->toArray();

                            // Delete removed commands
                            $record->commands()
                                ->whereIn('id', array_diff($existing, $submittedIds))
                                ->delete();

                            // Upsert each command with its new order
                            foreach ($submitted as $index => $item) {
                                $payload = [
                                    'command'     => $item['command'],
                                    'description' => $item['description'] ?? null,
                                    'order'       => $index,
                                ];

                                if (!empty($item['id'])) {
                                    // Update existing
                                    $record->commands()
                                        ->where('id', $item['id'])
                                        ->update($payload);
                                } else {
                                    // Create new
                                    $record->commands()->create($payload);
                                }
                            }
                        });
                    })
                    ->successNotificationTitle('Commands saved!')
                    ->after(function (Action $action) {
                        $action->sendSuccessNotification();
                    }),

                // ─── Copy Commands to Clipboard ────────────────────────────────
                Action::make('copy_commands')
                    ->label('Copy')
                    ->icon('heroicon-o-clipboard')
                    ->color('warning')
                    ->tooltip('Copy all commands to clipboard')
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
                        $action->successNotificationTitle('Commands copied to clipboard!')
                            ->sendSuccessNotification();
                    }),

                DissociateAction::make(),
                DeleteAction::make()
                    ->authorize(fn () => auth()->user()->id == $this->getOwnerRecord()->user_id),
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