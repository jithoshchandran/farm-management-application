<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MilkProductionSummary extends Model
{
    protected $table = 'milk_production_summaries';
    public $timestamps = false;
    protected $primaryKey = 'cow_id';

    public function cow(): BelongsTo
    {
        return $this->belongsTo(Cow::class, 'cow_id');
    }
}
