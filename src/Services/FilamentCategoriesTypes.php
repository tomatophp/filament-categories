<?php

namespace TomatoPHP\FilamentCategories\Services;

use Illuminate\Support\Str;
use TomatoPHP\FilamentCategories\Services\Contracts\CategoriesType;

class FilamentCategoriesTypes
{
    public static array $categoriesTypes = [];

    public static function register(CategoriesType|array $categoriesType)
    {
        if(is_array($categoriesType)) {
            foreach($categoriesType as $type) {
                self::register($type);
            }
            return;
        }

        self::$categoriesTypes[] = $categoriesType;
    }

    public static function getOptions()
    {
        return collect(self::$categoriesTypes);
    }
}