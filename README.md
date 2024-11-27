![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-categories/master/art/screenshot.jpg)

# Filament categories

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-categories/version.svg)](https://packagist.org/packages/tomatophp/filament-categories)
[![License](https://poser.pugx.org/tomatophp/filament-categories/license.svg)](https://packagist.org/packages/tomatophp/filament-categories)
[![Downloads](https://poser.pugx.org/tomatophp/filament-categories/d/total.svg)](https://packagist.org/packages/tomatophp/filament-categories)

Manage your categories for any model type with relation manager integration for TomatoPHP

## Installation

```bash
composer require tomatophp/filament-categories
```
after install your package please run this command

```bash
php artisan filament-categories:install
```

finally register the plugin on `/app/Providers/Filament/AdminPanelProvider.php`

```php
->plugin(\TomatoPHP\FilamentCategories\FilamentCategoriesPlugin::make())
```


## Publish Assets

you can publish config file by use this command

```bash
php artisan vendor:publish --tag="filament-categories-config"
```

you can publish views file by use this command

```bash
php artisan vendor:publish --tag="filament-categories-views"
```

you can publish languages file by use this command

```bash
php artisan vendor:publish --tag="filament-categories-lang"
```

you can publish migrations file by use this command

```bash
php artisan vendor:publish --tag="filament-categories-migrations"
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

Please see [SECURITY](SECURITY.md) for more information about security.

## Credits

- [Fady Mondy](mailto:info@3x1.io)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
