<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CryocanInspection extends Model
{
    protected $fillable = [
        'cryocan_id',
        'inspection_date',
        'liquid_level_cm',
        'vacuum_status',
        'physical_condition',
        'notes',
    ];

    protected static function booted()
    {
        static::saved(fn ($inspection) => $inspection->syncToCryocan());
        static::deleted(fn ($inspection) => $inspection->syncToCryocan());
    }

    public function syncToCryocan()
    {
        $latest = $this->cryocan->inspections()->latest('inspection_date')->first();

        if ($latest) {
            $this->cryocan->update([
                'current_level_cm' => $latest->liquid_level_cm,
            ]);
        } else {
            $this->cryocan->update([
                'current_level_cm' => null,
            ]);
        }
    }

    public function cryocan()
    {
        return $this->belongsTo(Cryocan::class);
    }
}
