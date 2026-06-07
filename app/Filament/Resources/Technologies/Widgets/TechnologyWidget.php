<?php

namespace App\Filament\Resources\Technologies\Widgets;

use App\Models\Technology;
use Filament\Widgets\Widget;

class TechnologyWidget extends Widget
{
    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.resources.technologies.widgets.technology-widget';

    public function getTechnologiesCount(): int
    {
        return Technology::where('user_id', auth()->user()->id)->count();
    }

    public function getRecentTechnologies()
    {
        return Technology::where('user_id', auth()->user()->id)
            ->latest()
            ->take(5)
            ->get();
    }

    public function getTechnologiesPublishedCount()
    {
        return Technology::where('user_id', auth()->user()->id)->where('published', true)->count();
    }
}
