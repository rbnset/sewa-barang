<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactor, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'address',
        'is_open',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'store_id');
    }
}
