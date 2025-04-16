<?php

namespace TomatoPHP\FilamentCategories\Filament\Resources;

use Filament\Resources\Concerns\Translatable;
use Illuminate\Support\Str;
use TomatoPHP\FilamentCategories\Filament\Resources\CategoryResource\Pages;
use TomatoPHP\FilamentCategories\Filament\Resources\CategoryResource\RelationManagers;
use TomatoPHP\FilamentCategories\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use TomatoPHP\FilamentCategories\Models\Post;
use TomatoPHP\FilamentCategories\Services\FilamentCategoriesTypes;
use TomatoPHP\FilamentIcons\Components\IconColumn;
use TomatoPHP\FilamentIcons\Components\IconPicker;

class CategoryResource extends Resource
{
    use Translatable;

    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return trans('filament-categories::messages.content.group');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('filament-categories::messages.category.title');
    }

    public static function getLabel(): ?string
    {
        return trans('filament-categories::messages.category.single');
    }

    public static function getNavigationLabel(): string
    {
        return trans('filament-categories::messages.category.title');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make([
                    'default' => 1,
                    'sm' => 1,
                    'md' => 6,
                    'lg' => 12,
                ])->schema([
                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\Section::make(trans('filament-categories::messages.category.sections.details.title'))
                                ->description(trans('filament-categories::messages.category.sections.details.description'))
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->afterStateUpdated( fn(Forms\Get $get, Forms\Set $set)=> $set('slug', Str::of($get('name'))->replace(' ', '-')->lower()->toString()))
                                        ->label(trans('filament-categories::messages.category.sections.details.columns.name'))
                                        ->lazy()
                                        ->required(),
                                    Forms\Components\TextInput::make('slug')
                                        ->label(trans('filament-categories::messages.category.sections.details.columns.slug'))
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\Textarea::make('description')
                                        ->columnSpanFull()
                                        ->label(trans('filament-categories::messages.category.sections.details.columns.description')),
                                    IconPicker::make('icon')
                                        ->label(trans('filament-categories::messages.category.sections.details.columns.icon')),
                                    Forms\Components\ColorPicker::make('color')
                                        ->label(trans('filament-categories::messages.category.sections.details.columns.color'))
                                ])
                                ->columns(2),
                            Forms\Components\Section::make(trans('filament-categories::messages.category.sections.images.title'))
                                ->description(trans('filament-categories::messages.category.sections.images.description'))
                                ->schema([
                                    Forms\Components\SpatieMediaLibraryFileUpload::make('feature_image')
                                        ->label(trans('filament-categories::messages.category.sections.images.columns.feature_image'))
                                        ->collection('feature_image')
                                        ->image()
                                        ->maxFiles(1)
                                        ->maxSize(2048)
                                        ->maxWidth(1920),
                                    Forms\Components\SpatieMediaLibraryFileUpload::make('cover_image')
                                        ->label(trans('filament-categories::messages.category.sections.images.columns.cover_image'))
                                        ->collection('cover_image')
                                        ->image()
                                        ->maxFiles(1)
                                        ->maxSize(2048)
                                        ->maxWidth(1920),
                                ]),
                        ])
                        ->columnSpan([
                            'sm' => 1,
                            'md' => 4,
                            'lg' => 8,
                        ]),
                    Forms\Components\Section::make(trans('filament-categories::messages.category.sections.status.title'))
                        ->description(trans('filament-categories::messages.category.sections.status.description'))
                        ->schema([
                            Forms\Components\Select::make('for')
                                ->label(trans('filament-categories::messages.category.sections.status.columns.for'))
                                ->searchable()
                                ->live()
                                ->options(fn() => FilamentCategoriesTypes::getOptions()->pluck('label', 'key')->toArray())
                                ->default('post'),
                            Forms\Components\Select::make('type')
                                ->hidden(function(Forms\Get $get){
                                    $for = FilamentCategoriesTypes::getOptions()->where('key', $get('for'))->first();
                                    if($for && count($for->sub)){
                                        return false;
                                    }
                                })
                                ->label(trans('filament-categories::messages.category.sections.status.columns.type'))
                                ->searchable()
                                ->options(fn(Forms\Get $get) => FilamentCategoriesTypes::getOptions()->where('key', $get('for'))->first()?->getSub()->pluck('label', 'key')->toArray())
                                ->default('category'),
                            Forms\Components\Select::make('parent_id')
                                ->label(trans('filament-categories::messages.category.sections.status.columns.parent_id'))
                                ->searchable()
                                ->options(fn() => Category::query()->pluck('name', 'id')->toArray()),
                            Forms\Components\Toggle::make('is_active')
                                ->label(trans('filament-categories::messages.category.sections.status.columns.is_active')),
                            Forms\Components\Toggle::make('show_in_menu')
                                ->label(trans('filament-categories::messages.category.sections.status.columns.show_in_menu')),
                        ])
                        ->columnSpan([
                            'sm' => 1,
                            'md' => 2,
                            'lg' => 4,
                        ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('feature_image')
                    ->label(trans('filament-categories::messages.category.sections.images.columns.feature_image'))
                    ->defaultImageUrl(fn(Category $category)=> 'https://ui-avatars.com/api/?name='.Str::of($category->slug)->replace('-','+').'&color=FFFFFF&background=020617')
                    ->square()
                    ->collection('feature_image'),
                Tables\Columns\TextColumn::make('name')
                    ->description(fn(Category $category)=> Str::of($category->description)->limit(50))
                    ->label(trans('filament-categories::messages.category.sections.details.columns.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('for')
                    ->state(function (Category $category){
                        return FilamentCategoriesTypes::getOptions()->where('key', $category->for)->first()?->label;
                    })
                    ->color(function (Category $category){
                        return FilamentCategoriesTypes::getOptions()->where('key', $category->for)->first()?->color;
                    })
                    ->icon(function (Category $category){
                        return FilamentCategoriesTypes::getOptions()->where('key', $category->for)->first()?->icon;
                    })
                    ->badge()
                    ->sortable()
                    ->label(trans('filament-categories::messages.category.sections.status.columns.for'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->state(function (Category $category){
                        return FilamentCategoriesTypes::getOptions()->where('key', $category->for)->first()?->getSub()->where('key', $category->type)->first()?->label;
                    })
                    ->color(function (Category $category){
                        return FilamentCategoriesTypes::getOptions()->where('key', $category->for)->first()?->getSub()->where('key', $category->type)->first()?->color;
                    })
                    ->icon(function (Category $category){
                        return FilamentCategoriesTypes::getOptions()->where('key', $category->for)->first()?->getSub()->where('key', $category->type)->first()?->icon;
                    })
                    ->badge()
                    ->sortable()
                    ->label(trans('filament-categories::messages.category.sections.status.columns.type'))
                    ->searchable(),
                IconColumn::make('icon')
                    ->label(trans('filament-categories::messages.category.sections.details.columns.icon'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ColorColumn::make('color')
                    ->label(trans('filament-categories::messages.category.sections.details.columns.color'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->sortable()
                    ->label(trans('filament-categories::messages.category.sections.status.columns.is_active')),
                Tables\Columns\ToggleColumn::make('show_in_menu')
                    ->sortable()
                    ->label(trans('filament-categories::messages.category.sections.status.columns.show_in_menu')),
                Tables\Columns\TextColumn::make('parent.name')
                    ->sortable()
                    ->label(trans('filament-categories::messages.category.sections.status.columns.parent_id'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('for')
                    ->form([
                        Forms\Components\Select::make('for')
                            ->label(trans('filament-categories::messages.category.sections.status.columns.for'))
                            ->searchable()
                            ->live()
                            ->options(fn() => FilamentCategoriesTypes::getOptions()->pluck('label', 'key')->toArray()),
                        Forms\Components\Select::make('type')
                            ->hidden(function(Forms\Get $get){
                                $for = FilamentCategoriesTypes::getOptions()->where('key', $get('for'))->first();
                                if($for && count($for->sub)){
                                    return false;
                                }
                            })
                            ->label(trans('filament-categories::messages.category.sections.status.columns.type'))
                            ->searchable()
                            ->options(fn(Forms\Get $get) => FilamentCategoriesTypes::getOptions()->where('key', $get('for'))->first()?->getSub()->pluck('label', 'key')->toArray()),

                    ])
                    ->query(function (Builder $query, array $data){
                        $query->when(
                            $data['for'],
                            fn(Builder $query, $for) => $query->where('for', $for)
                        )->when(
                            $data['type'],
                            fn(Builder $query, $type) => $query->where('type', $type)
                        );
                    }),
                Tables\Filters\TrashedFilter::make()
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton()
                    ->tooltip(__('filament-actions::view.single.label')),
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->tooltip(__('filament-actions::edit.single.label')),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->tooltip(__('filament-actions::delete.single.label')),
                Tables\Actions\ForceDeleteAction::make()
                    ->iconButton()
                    ->tooltip(__('filament-actions::force-delete.single.label')),
                Tables\Actions\RestoreAction::make()
                    ->iconButton()
                    ->tooltip(__('filament-actions::restore.single.label')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}