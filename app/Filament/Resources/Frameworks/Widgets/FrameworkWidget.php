<?php

namespace App\Filament\Resources\Frameworks\Widgets;

use Filament\Widgets\Widget;
use App\Models\Framework;

class FrameworkWidget extends Widget
{
    protected int|string|array $columnSpan = 'full';
    
    protected  string $view = 'filament.resources.frameworks.widgets.framework-widget';
    
    public function getFrameworksCount(): int
    {
        return Framework::where('user_id', auth()->user()->id)->count();
    }
    
    public function getRecentFrameworks()
    {
        return Framework::where('user_id', auth()->user()->id)
            ->latest()
            ->take(5)
            ->get();
    }

    public function getFrameworksPublishedCount()
    {
        return Framework::where('user_id', auth()->user()->id)->where('published', true)->count();
    }
}