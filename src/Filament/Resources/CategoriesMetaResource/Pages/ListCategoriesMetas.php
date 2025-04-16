<?php

namespace TomatoPHP\FilamentCategories\Filament\Resources\CategoriesMetaResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use TomatoPHP\FilamentCategories\Filament\Resources\CategoriesMetaResource;

class ListCategoriesMetas extends ListRecords
{
    protected static string $resource = CategoriesMetaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
