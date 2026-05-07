<?php

namespace App\Observers;

use App\Models\FeedAllocation;

class FeedAllocationObserver
{
    /**
     * Handle the FeedAllocation "created" event.
     */
    public function created(FeedAllocation $feedAllocation): void
    {
        // Deduct from inventory
        if ($feedAllocation->feed) {
            $feedAllocation->feed->decrement('quantity_in_stock', $feedAllocation->amount);
        }
    }

    /**
     * Handle the FeedAllocation "deleted" event.
     */
    public function deleted(FeedAllocation $feedAllocation): void
    {
        // Restore inventory if allocation is deleted
        if ($feedAllocation->feed) {
            $feedAllocation->feed->increment('quantity_in_stock', $feedAllocation->amount);
        }
    }
}
