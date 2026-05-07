<?php

namespace App\Filament\Resources\Frameworks\Tables;


use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\Layout\Stack;

class FrameworksTable
{
    public static function configure(Table $table): Table
    {
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
                    TextColumn::make('titre')
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
                    'class' => 'p-6   bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300',
                ]),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make()
                        ->hidden(fn ($record) => $record->user_id !== auth()->id()),
                DeleteAction::make()
                        ->hidden(fn ($record) => $record->user_id !== auth()->id()),
            ]);
    }
}