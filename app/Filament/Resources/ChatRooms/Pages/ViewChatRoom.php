<?php

namespace App\Filament\Resources\ChatRooms\Pages;

use App\Filament\Resources\ChatRooms\ChatRoomResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\View\View;

class ViewChatRoom extends ViewRecord
{
    protected static string $resource = ChatRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    public function getFooter(): ?View
    {
        $record = $this->getRecord();

        return view('filament.resources.chat-rooms.footer', [
            'chatRoom' => $record,
        ]);
    }
}
