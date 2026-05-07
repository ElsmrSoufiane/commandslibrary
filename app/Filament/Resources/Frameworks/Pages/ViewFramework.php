<?php

namespace App\Filament\Resources\Frameworks\Pages;

use App\Filament\Resources\Frameworks\FrameworkResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFramework extends ViewRecord
{
    protected static string $resource = FrameworkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                        ->hidden(fn ($record) => $record->user_id !== auth()->id()),
        ];
    }
}
