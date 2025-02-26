<?php

namespace TomatoPHP\FilamentCategories;

use Filament\Contracts\Plugin;
use Filament\Panel;
use TomatoPHP\FilamentCategories\Filament\Resources\CategoriesMetaResource;
use TomatoPHP\FilamentCategories\Filament\Resources\CategoryResource;

class FilamentCategoriesPlugin implements Plugin
{
    private bool $isActive = false;

    public function getId(): string
    {
        return 'filament-categories';
    }

    public function register(Panel $panel): void
    {
        if(class_exists(Module::class) && \Nwidart\Modules\Facades\Module::find('FilamentCategories')?->isEnabled()){
            $this->isActive = true;
        }
        else {
            $this->isActive = true;
        }

        if($this->isActive) {
            $panel->resources([
                CategoryResource::class,
                CategoriesMetaResource::class
            ]);
        }
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
