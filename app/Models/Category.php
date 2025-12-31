<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'image',
        'sort_order',
    ];

    /* -----------------------------
     | Relationships
     |-----------------------------*/
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order')->orderBy('name');
    }

    /**
     * OPTIONAL: only if you have a Listing model & listings table.
     * Adjust foreign key if your listings use a different column.
     */
    public function listings()
    {
        return $this->hasMany(\App\Models\Listing::class, 'category_id');
    }

    /* -----------------------------
     | Scopes
     |-----------------------------*/
    public function scopeParents(Builder $q): Builder
    {
        return $q->whereNull('parent_id');
    }

    public function scopeSubs(Builder $q): Builder
    {
        return $q->whereNotNull('parent_id');
    }

    public function scopeSearch(Builder $q, ?string $term): Builder
    {
        $term = trim((string) $term);
        if ($term === '') return $q;

        return $q->where(function ($qq) use ($term) {
            $qq->where('name', 'like', "%{$term}%")
               ->orWhere('slug', 'like', "%{$term}%");
        });
    }

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderByRaw('CASE WHEN parent_id IS NULL THEN 0 ELSE 1 END')
                 ->orderBy('parent_id')
                 ->orderBy('sort_order')
                 ->orderBy('name');
    }

    /* -----------------------------
     | Model Events (slug)
     |-----------------------------*/
    protected static function booted()
    {
        static::saving(function (Category $cat) {
            if (blank($cat->slug)) {
                $cat->slug = Str::slug($cat->name);
            } else {
                $cat->slug = Str::slug($cat->slug);
            }

            $cat->slug = self::makeUniqueSlug($cat->slug, $cat->id);
        });
        static::saved(fn () => Cache::forget('top_categories_v1'));
        static::deleted(fn () => Cache::forget('top_categories_v1'));
    }

    private static function makeUniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $slug = $baseSlug;
        $i = 2;

        while (
            self::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $i;
            $i++;
        }

        return $slug;
    }



}
