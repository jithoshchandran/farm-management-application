<?php

namespace App\Observers;

use App\Models\Feed;
use App\Models\FeedPurchase;

class FeedPurchaseObserver
{
    public function created(FeedPurchase $feedPurchase): void
    {
        $this->adjustStock($feedPurchase->feed_id, (float) $feedPurchase->quantity);
        $this->syncCurrentUnitPrice($feedPurchase->feed_id);
    }

    public function updated(FeedPurchase $feedPurchase): void
    {
        $oldFeedId = $feedPurchase->getOriginal('feed_id') ?: $feedPurchase->feed_id;
        $newFeedId = $feedPurchase->feed_id;
        $oldQuantity = (float) ($feedPurchase->getOriginal('quantity') ?? 0);
        $newQuantity = (float) ($feedPurchase->quantity ?? 0);

        if ((int) $oldFeedId === (int) $newFeedId) {
            $this->adjustStock($newFeedId, $newQuantity - $oldQuantity);
        } else {
            $this->adjustStock($oldFeedId, -$oldQuantity);
            $this->adjustStock($newFeedId, $newQuantity);
        }

        $this->syncCurrentUnitPrice($oldFeedId);

        if ((int) $oldFeedId !== (int) $newFeedId) {
            $this->syncCurrentUnitPrice($newFeedId);
        }
    }

    public function deleted(FeedPurchase $feedPurchase): void
    {
        $this->adjustStock($feedPurchase->feed_id, -(float) $feedPurchase->quantity);
        $this->syncCurrentUnitPrice($feedPurchase->feed_id);
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

    private function syncCurrentUnitPrice(?int $feedId): void
    {
        if (! $feedId) {
            return;
        }

        $latestPurchase = FeedPurchase::query()
            ->where('feed_id', $feedId)
            ->orderByDesc('purchase_date')
            ->orderByDesc('id')
            ->first();

        if (! $latestPurchase) {
            return;
        }

        Feed::whereKey($feedId)->update([
            'cost_per_kg' => $latestPurchase->unit_price,
        ]);
    }
}
