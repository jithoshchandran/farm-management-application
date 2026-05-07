<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Treatment extends Model
{
    protected $guarded = [];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'withdrawal_end_date' => 'date',
        'medicines' => 'array',
    ];

    public function cow(): BelongsTo
    {
        return $this->belongsTo(Cow::class);
    }
}
