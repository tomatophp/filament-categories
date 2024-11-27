<?php

namespace TomatoPHP\FilamentCategories;

use Illuminate\Support\ServiceProvider;


class FilamentCategoriesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Register generate command
        $this->commands([
           \TomatoPHP\FilamentCategories\Console\FilamentCategoriesInstall::class,
        ]);
 
        //Register Config file
        $this->mergeConfigFrom(__DIR__.'/../config/filament-categories.php', 'filament-categories');
 
        //Publish Config
        $this->publishes([
           __DIR__.'/../config/filament-categories.php' => config_path('filament-categories.php'),
        ], 'filament-categories-config');
 
        //Register Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
 
        //Publish Migrations
        $this->publishes([
           __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'filament-categories-migrations');
        //Register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-categories');
 
        //Publish Views
        $this->publishes([
           __DIR__.'/../resources/views' => resource_path('views/vendor/filament-categories'),
        ], 'filament-categories-views');
 
        //Register Langs
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-categories');
 
        //Publish Lang
        $this->publishes([
           __DIR__.'/../resources/lang' => base_path('lang/vendor/filament-categories'),
        ], 'filament-categories-lang');
 
        //Register Routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
 
    }

    public function boot(): void
    {
        //you boot methods here
    }
}
