<?php

namespace App\Filament\Resources\Frameworks\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FrameworkInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Framework Identity'))
                    ->description(__('Basic information about the framework'))
                    ->columns(3)
                    ->schema([
                        ImageEntry::make('logo')
                            ->label(__('Logo'))
                            ->placeholder('-')
                            ->height(150)
                            ->width(150),

                        TextEntry::make('titre')
                            ->label(__('Framework Title'))
                            ->weight('bold')
                            ->size('lg')
                            ->color('primary')
                            ->copyable()
                            ->columnSpan(2),

                        TextEntry::make('user_id')
                            ->label(__('Author'))
                            ->numeric()
                            ->badge()
                            ->color('info')
                            ->icon('heroicon-o-user')
                            ->formatStateUsing(function ($state) {
                               return \App\Models\User::find($state)?->name ?? __('Unknown');
                            }),
                        TextEntry::make('description')
                            ->label(__('Description'))
                            ->markdown()
                            ->columnSpan(2)
                            ->placeholder(__('No description provided')),
                    ]),

                Section::make(__('Timestamps'))
                    ->description(__('Record metadata'))
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('created_at')
                            ->label(__('Created'))
                            ->dateTime('d M Y, H:i')
                            ->since()
                            ->icon('heroicon-o-clock')
                            ->iconColor('success')
                            ->color('success'),

                        TextEntry::make('updated_at')
                            ->label(__('Last Updated'))
                            ->dateTime('d M Y, H:i')
                            ->since()
                            ->icon('heroicon-o-arrow-path')
                            ->iconColor('warning')
                            ->color('warning'),
                    ]),
            ]);
    }
}