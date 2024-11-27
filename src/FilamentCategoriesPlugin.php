<?php

namespace TomatoPHP\FilamentCategories;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentCategoriesPlugin implements Plugin
{

    public function getId(): string
    {
        return 'filament-categories';
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): self
    {
        return new FilamentCategoriesPlugin;
    }
}
