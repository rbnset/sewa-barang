<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'sotre_id',
        'name',
        'trx_id',
        'phone_number',
        'address',
        'total_amount',
        'is_paid',
        'proof',
        'started_at',
        'ended_at',
        'delivery',
    ];

    protected $casts = [
        'total_amount' => MoneyCast::class,
        'started_at' => 'date',
        'ended_at' => 'date'
    ];

    public static function generateUniqueTrxId()
    {
        $prefix = 'SEWARD';
        do {
            $randomString = $prefix . mt_rand(1000, 9990);
        } while (self::where('trx_id', $randomString)->exists());

        return $randomString;
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'transaction_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'transaction_id');
    }
}
