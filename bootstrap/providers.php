<?php

use App\Providers\AppServiceProvider;
use App\Providers\Filament\UserPanelProvider;
use App\Providers\FortifyServiceProvider;

return [
    AppServiceProvider::class,
    UserPanelProvider::class,
    FortifyServiceProvider::class,
];
