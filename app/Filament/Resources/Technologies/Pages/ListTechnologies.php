<?php

namespace App\Filament\Resources\Technologies\Pages;

use App\Filament\Resources\Technologies\TechnologyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListTechnologies extends ListRecords
{
    protected static string $resource = TechnologyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            Tab::make('All')
                ->icon('heroicon-m-bars-4')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('published', true)),
            Tab::make('Mine')
                ->icon('heroicon-m-user-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', auth()->user()->id)),
            Tab::make('Others')
                ->icon('heroicon-m-user-group')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', '!=', auth()->user()->id)->where('published', true)),

        ];
    }
}
