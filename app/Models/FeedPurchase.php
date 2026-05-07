<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedPurchase extends Model
{
    protected $guarded = [];

    protected $casts = [
        'purchase_date' => 'date',
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::saving(function (FeedPurchase $purchase): void {
            $feed = $purchase->feed_id ? Feed::find($purchase->feed_id) : null;

            if ($feed) {
                $purchase->category = $feed->category;
                $purchase->unit = $feed->unit ?: 'kg';
            }

            $purchase->total = round(
                (float) ($purchase->quantity ?? 0) * (float) ($purchase->unit_price ?? 0),
                2
            );
        });
    }

    public function feed(): BelongsTo
    {
        return $this->belongsTo(Feed::class);
    }
}
