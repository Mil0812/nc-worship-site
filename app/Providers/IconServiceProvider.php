<?php

namespace App\Providers;

use BladeUI\Icons\Exceptions\CannotRegisterIconSet;
use BladeUI\Icons\Factory;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class IconServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     * @throws CannotRegisterIconSet
     */
    public function boot(): void
    {
        $this->callAfterResolving(Factory::class, function (Factory $factory) {
            $factory->add('icons', [
                'path' => public_path('icons'),
                'prefix' => 'icons',
            ]);
        });
    }
}
