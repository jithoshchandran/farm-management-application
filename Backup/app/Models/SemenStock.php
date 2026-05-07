<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SemenStock extends Model
{
    protected $fillable = [
        'bull_name',
        'bull_tag',
        'breed',
        'batch_date',
        'collection_date',
        'purchase_date',
        'contact_name',
        'contact_location',
        'contact_phone_1',
        'contact_phone_2',
        'purchase_cost',
        'cryocan_id',
        'sire_name',
        'dam_name',
        'bull_image',
        'sire_image',
        'dam_image',
        'notes',
        'initial_quantity',
        'remaining_quantity',
    ];

    protected $casts = [
        'batch_date' => 'date',
        'collection_date' => 'date',
        'purchase_date' => 'date',
    ];

    public function getFullDisplayNameAttribute()
    {
        return "{$this->bull_name}/SID" . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    public function inseminations()
    {
        return $this->hasMany(Insemination::class);
    }

    public function cryocan()
    {
        return $this->belongsTo(Cryocan::class);
    }
}
