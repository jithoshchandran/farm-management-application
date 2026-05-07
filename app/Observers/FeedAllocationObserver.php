<?php

namespace App\Observers;

use App\Models\Feed;
use App\Models\FeedAllocation;

class FeedAllocationObserver
{
    /**
     * Handle the FeedAllocation "created" event.
     */
    public function created(FeedAllocation $feedAllocation): void
    {
        $this->adjustStock($feedAllocation->feed_id, -$this->quantity($feedAllocation));
    }

    public function updated(FeedAllocation $feedAllocation): void
    {
        $oldFeedId = $feedAllocation->getOriginal('feed_id') ?: $feedAllocation->feed_id;
        $newFeedId = $feedAllocation->feed_id;
        $oldQuantity = $this->originalQuantity($feedAllocation);
        $newQuantity = $this->quantity($feedAllocation);

        if ((int) $oldFeedId === (int) $newFeedId) {
            $this->adjustStock($newFeedId, $oldQuantity - $newQuantity);

            return;
        }

        $this->adjustStock($oldFeedId, $oldQuantity);
        $this->adjustStock($newFeedId, -$newQuantity);
    }

    /**
     * Handle the FeedAllocation "deleted" event.
     */
    public function deleted(FeedAllocation $feedAllocation): void
    {
        $this->adjustStock($feedAllocation->feed_id, $this->quantity($feedAllocation));
    }

    private function quantity(FeedAllocation $feedAllocation): float
    {
        return (float) ($feedAllocation->quantity ?? $feedAllocation->amount ?? 0);
    }

    private function originalQuantity(FeedAllocation $feedAllocation): float
    {
        return (float) (
            $feedAllocation->getOriginal('quantity')
            ?? $feedAllocation->getOriginal('amount')
            ?? 0
        );
    }

    private function adjustStock(?int $feedId, float $quantity): void
    {
        if (! $feedId || $quantity === 0.0) {
            return;
        }

        if ($quantity > 0) {
            Feed::whereKey($feedId)->increment('quantity_in_stock', $quantity);

            return;
        }

        Feed::whereKey($feedId)->decrement('quantity_in_stock', abs($quantity));
    }
}
