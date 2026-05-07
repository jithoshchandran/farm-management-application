<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Feed extends Model
{
    protected $guarded = [];

    public function allocations(): HasMany
    {
        return $this->hasMany(FeedAllocation::class);
    }
}
