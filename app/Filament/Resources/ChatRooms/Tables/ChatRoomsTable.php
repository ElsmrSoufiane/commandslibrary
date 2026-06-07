<?php

namespace App\Filament\Resources\ChatRooms\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Number;

class ChatRoomsTable
{
    public function isOwner($record): bool
    {
        return auth()->user()->isChatRoomAdmin($record);
    }

    public static function configure(Table $table): Table
    {
        $instance = new static;

        return $table
            ->columns([
                Stack::make([
                    ImageColumn::make('logo')
                        ->height(80)
                        ->width(80)
                        ->alignCenter()
                        ->circular()
                        ->extraImgAttributes([
                            'class' => 'object-cover shadow-md',
                        ]),
                    TextColumn::make('title')
                        ->searchable()
                        ->size('lg')
                        ->weight('bold')
                        ->alignCenter()
                        ->extraAttributes([
                            'class' => 'mt-2',
                        ]),
                    TextColumn::make('description')
                        ->searchable()
                        ->size('sm')
                        ->color('gray')
                        ->alignCenter()
                        ->limit(100)
                        ->extraAttributes([
                            'class' => 'text-center px-2',
                        ]),
                    TextColumn::make('tags.name')
                        ->label(__('Tags'))
                        ->badge()
                        ->color('primary')
                        ->alignCenter()
                        ->extraAttributes([
                            'class' => 'mt-1 gap-1 flex flex-wrap justify-center',
                        ]),
                    TextColumn::make('members_count')
                        ->label(__('Members'))
                        ->alignCenter()
                        ->state(fn ($record) => Number::abbreviate($record->members()->count()))
                        ->color('gray')
                        ->size('sm')
                        ->extraAttributes([
                            'class' => 'mt-1',
                        ]),
                    Stack::make([
                        TextColumn::make('created_at')
                            ->dateTime('d M Y')
                            ->sortable()
                            ->toggleable(isToggledHiddenByDefault: true)
                            ->size('xs')
                            ->alignCenter()
                            ->color('gray')
                            ->prefix('Created: '),
                        TextColumn::make('updated_at')
                            ->dateTime('d M Y')
                            ->sortable()
                            ->toggleable(isToggledHiddenByDefault: true)
                            ->size('xs')
                            ->alignCenter()
                            ->color('gray')
                            ->prefix('Updated: '),
                    ])->space(1)->extraAttributes([
                        'class' => 'mt-2',
                    ]),
                ])
                    ->space(3)
                    ->extraAttributes([
                        'class' => 'p-6 bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300',
                    ]),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                ViewAction::make()
                    ->authorize(fn ($record) => $instance->isOwner($record)),
                EditAction::make()
                    ->authorize(fn ($record) => $instance->isOwner($record)),
                DeleteAction::make()
                    ->authorize(fn ($record) => $instance->isOwner($record)),
            ]);
    }
}
