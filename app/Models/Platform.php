<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Platform extends Model
{
    use HasSlug;

    protected $table = 'platforms';

    protected $fillable = [
        'platform_category_id',
        'logo',
        'name',
        'slug',
        'short_description',
        'access_url',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function categories()
    {
        return $this->belongsToMany(PlatformCategory::class, 'category_platform', 'platform_id', 'platform_category_id')->withTimestamps();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PlatformCategory::class, 'platform_category_id');
    }
}
