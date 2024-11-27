<?php

namespace TomatoPHP\FilamentCategories\Models;

use App\Models\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

/**
 * @property integer $id
 * @property integer $parent_id
 * @property string $for
 * @property string $type
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $icon
 * @property string $color
 * @property boolean $is_active
 * @property boolean $show_in_menu
 * @property string $created_at
 * @property string $updated_at
 */
class Category extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasTranslations;
    use SoftDeletes;

    public $translatable = [
        'name',
        'description'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'type',
        'for',
        'parent_id',
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'is_active',
        'show_in_menu',
        'created_at',
        'updated_at'
    ];


    protected $casts = [
        'is_active' => 'boolean',
        'show_in_menu' => 'boolean',
    ];

    /**
     * @return ?BelongsTo
     */
    public function team(): ?BelongsTo
    {
        return class_exists(Team::class) ? $this->belongsTo(Team::class) : null;
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany('TomatoPHP\FilamentCategories\Models\Category', 'parent_id');
    }


    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo('TomatoPHP\FilamentCategories\Models\Category', 'parent_id');
    }

}
