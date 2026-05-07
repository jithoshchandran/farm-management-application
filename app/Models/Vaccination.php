<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vaccination extends Model
{
    protected $guarded = [];
    protected $casts = [
        'date_administered' => 'date',
        'next_due_date' => 'date',
    ];

    public function cow(): BelongsTo
    {
        return $this->belongsTo(Cow::class);
    }
}
