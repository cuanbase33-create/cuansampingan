<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class PlatformCategory extends Model
{
    use HasSlug;

    protected $table = 'platform_categories';

    protected $fillable = [
        'name',
        'slug',
        'sort_order',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'category_platform', 'platform_category_id', 'platform_id')->withTimestamps()->orderBy('sort_order');
    }
}
