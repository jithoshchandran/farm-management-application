<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CryocanRefill extends Model
{
    protected $fillable = [
        'cryocan_id',
        'refill_date',
        'quantity_liters',
        'cost',
        'notes',
    ];

    protected static function booted()
    {
        static::saved(fn ($refill) => $refill->syncToCryocan());
        static::deleted(fn ($refill) => $refill->syncToCryocan());
    }

    public function syncToCryocan()
    {
        $latest = $this->cryocan->refills()->latest('refill_date')->first();

        if ($latest) {
            $this->cryocan->update([
                'last_refill_date' => $latest->refill_date,
                'refill_quantity_liters' => $latest->quantity_liters,
                'refill_price' => $latest->cost,
            ]);
        } else {
            $this->cryocan->update([
                'last_refill_date' => null,
                'refill_quantity_liters' => null,
                'refill_price' => null,
            ]);
        }
    }

    public function cryocan()
    {
        return $this->belongsTo(Cryocan::class);
    }
}
