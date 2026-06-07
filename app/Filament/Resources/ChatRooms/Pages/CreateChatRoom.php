<?php

namespace App\Filament\Resources\ChatRooms\Pages;

use App\Filament\Resources\ChatRooms\ChatRoomResource;
use App\Models\ChatRoom;
use Filament\Resources\Pages\CreateRecord;

class CreateChatRoom extends CreateRecord
{
    protected static string $resource = ChatRoomResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->getRecord()->members()->attach(auth()->id(), ['role' => 'admin']);
    }
}
