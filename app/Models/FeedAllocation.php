<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedAllocation extends Model
{
    protected $guarded = [];
    protected $casts = ['date' => 'date'];

    public function feed(): BelongsTo
    {
        return $this->belongsTo(Feed::class);
    }

    public function cow(): BelongsTo
    {
        return $this->belongsTo(Cow::class);
    }
}
