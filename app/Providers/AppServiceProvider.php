<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;
use Filament\Panel;
use BezhanSalleh\LanguageSwitch\LanguageSwitch;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
        $switch->locales(['en', 'ar']);
        });
        Panel::configureUsing(function (Panel $panel) {
        $panel->brandLogo(asset('favicon.png'));
    });
        FilamentView::registerRenderHook(
            'panels::auth.login.form.after',
            fn (): string => Blade::render('
                <div class="mt-4 text-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        Don\'t have an account?
                    </span>
                    <a href="{{ filament()->getRegistrationUrl() }}" 
                       class="text-sm font-semibold text-primary-600 hover:text-primary-500">
                        Register here
                    </a>
                </div>
            ')
        );
    
        $this->configureDefaults();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
