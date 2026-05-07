<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cow;

class Insemination extends Model
{
    protected $fillable = [
        'cow_id',
        'date',
        'type',
        'bull_tag',
        'semen_batch_code',
        'technician_name',
        'cost',
        'notes',
        'is_successful',
        'expected_calving_date',
        'semen_stock_id',
        'straws_used',
    ];

    protected $casts = [
        'date' => 'date',
        'is_successful' => 'boolean',
        'expected_calving_date' => 'date',
    ];

    public function cow()
    {
        return $this->belongsTo(Cow::class);
    }

    public function semenStock()
    {
        return $this->belongsTo(SemenStock::class);
    }
}
