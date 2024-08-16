<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug', //uniq text generate otomatis dari name untuk SEO Frindly pada alamt URL misal implementasi pada bagian detail product
        'icon',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function brandCategories(): HasMany
    {
        return $this->hasMany(BrandCategory::class, 'category_id');
    }


    public function product(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
