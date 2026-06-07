<?php

namespace App\Filament\Resources\Communities\Pages;

use App\Filament\Resources\Communities\CommunityResource;
use App\Models\CommunityAdmin;
use Filament\Resources\Pages\CreateRecord;

class CreateCommunity extends CreateRecord
{
    protected static string $resource = CommunityResource::class;

    protected function afterCreate(): void
    {
        CommunityAdmin::create([
            'community_id' => $this->getRecord()->id,
            'user_id' => auth()->id(),
        ]);
    }
}
