<?php

namespace TomatoPHP\FilamentCategories\Filament\Resources\CategoriesMetaResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use TomatoPHP\FilamentCategories\Filament\Resources\CategoriesMetaResource;

class EditCategoriesMeta extends EditRecord
{
    protected static string $resource = CategoriesMetaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
