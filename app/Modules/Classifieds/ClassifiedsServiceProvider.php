<?php

namespace App\Modules\Classifieds;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Modules\Classifieds\Services\ClassifiedOnboardingService;

class ClassifiedsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Config/classifieds.php',
            'classifieds'
        );

        $this->app->singleton(ClassifiedOnboardingService::class, function () {
            return new ClassifiedOnboardingService();
        });
    }

    public function boot(): void
    {
        \Log::info('ClassifiedsServiceProvider booted');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'classifieds');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->publishes([
            __DIR__ . '/Config/classifieds.php' => config_path('classifieds.php'),
        ], 'classifieds-config');
    }
}