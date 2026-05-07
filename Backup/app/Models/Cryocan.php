<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cryocan extends Model
{
    const STATUS_ACTIVE = 'Active';
    const STATUS_MAINTENANCE = 'Maintenance';
    const STATUS_EMPTY = 'Empty';

    protected $fillable = [
        'serial_number',
        'tank_size_liters',
        'last_refill_date',
        'refill_quantity_liters',
        'refill_price',
        'next_scheduled_refill',
        'current_level_cm',
        'supplier_name',
        'technician_contact',
        'notes',
        'status',
    ];
    public function refills()
    {
        return $this->hasMany(CryocanRefill::class);
    }

    public function inspections()
    {
        return $this->hasMany(CryocanInspection::class);
    }
}
