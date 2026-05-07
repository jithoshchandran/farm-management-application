<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Feed extends Model
{
    public const CATEGORY_OPTIONS = [
        'Green Fodder' => 'Green Fodder',
        'Dry Fodder' => 'Dry Fodder',
        'Concentrates' => 'Concentrates',
        'Food Supplements & Vitamins' => 'Food Supplements & Vitamins',
        'Mineral Licks' => 'Mineral Licks',
    ];

    public const UNIT_OPTIONS = [
        'kg' => 'Kg',
        'ltr' => 'Ltr',
        'bag' => 'Bag',
        'packet' => 'Packet',
        'ton' => 'Ton',
        'piece' => 'Piece',
    ];

    protected $guarded = [];

    protected $casts = [
        'quantity_in_stock' => 'decimal:2',
        'cost_per_kg' => 'decimal:2',
    ];

    public function allocations(): HasMany
    {
        return $this->hasMany(FeedAllocation::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(FeedPurchase::class);
    }

    public function getUnitLabelAttribute(): string
    {
        $unit = $this->unit ?: 'kg';

        return self::UNIT_OPTIONS[$unit] ?? ucfirst((string) $unit);
    }
}
