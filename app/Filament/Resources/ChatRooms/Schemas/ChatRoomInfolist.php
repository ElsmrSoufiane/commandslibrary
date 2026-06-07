<?php

namespace App\Filament\Resources\ChatRooms\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ChatRoomInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Chat Room Identity'))
                    ->description(__('Basic information about the chat room'))
                    ->columns(3)
                    ->schema([
                        ImageEntry::make('logo')
                            ->label(__('Logo'))
                            ->placeholder('-')
                            ->height(150)
                            ->width(150),

                        TextEntry::make('title')
                            ->label(__('Title'))
                            ->weight('bold')
                            ->size('lg')
                            ->color('primary')
                            ->copyable()
                            ->columnSpan(2),

                        TextEntry::make('description')
                            ->label(__('Description'))
                            ->markdown()
                            ->columnSpanFull()
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
