<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MilkProduction extends Model
{
    protected $guarded = [];
    protected $casts = ['date' => 'date'];

    public function cow(): BelongsTo
    {
        return $this->belongsTo(Cow::class);
    }
}
