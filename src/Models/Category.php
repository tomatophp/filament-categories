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
 * @property int $id
 * @property int $parent_id
 * @property string $for
 * @property string $type
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $icon
 * @property string $color
 * @property bool $is_active
 * @property bool $show_in_menu
 * @property string $created_at
 * @property string $updated_at
 */
class Category extends Model implements HasMedia
{
    use HasTranslations;
    use InteractsWithMedia;
    use SoftDeletes;

    public $translatable = [
        'name',
        'description',
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
        'updated_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_in_menu' => 'boolean',
    ];

    public function team(): ?BelongsTo
    {
        return class_exists(Team::class) ? $this->belongsTo(Team::class) : null;
    }

    public function children(): HasMany
    {
        return $this->hasMany('TomatoPHP\FilamentCategories\Models\Category', 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo('TomatoPHP\FilamentCategories\Models\Category', 'parent_id');
    }
}
