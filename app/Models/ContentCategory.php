<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ContentCategory extends Model
{
    use HasSlug;

    protected $table = 'content_categories';

    protected $fillable = [
        'type',
        'name',
        'slug',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->allowDuplicateSlugs(); // Since it has a unique composite index (type, slug) rather than absolute unique slug
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'content_category_id');
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'content_category_id');
    }

    public function freeResources(): HasMany
    {
        return $this->hasMany(FreeResource::class, 'content_category_id');
    }

    public function digitalProducts(): HasMany
    {
        return $this->hasMany(DigitalProduct::class, 'content_category_id');
    }

    public function tutorials(): HasMany
    {
        return $this->hasMany(Tutorial::class, 'content_category_id');
    }
}
