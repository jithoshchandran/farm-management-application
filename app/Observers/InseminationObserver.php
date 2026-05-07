<?php

namespace App\Observers;

use App\Models\Insemination;

class InseminationObserver
{
    /**
     * Handle the Insemination "created" event.
     */
    public function created(Insemination $insemination): void
    {
        $cow = $insemination->cow;
        if ($cow) {
            if ($insemination->is_successful === true) {
                $cow->status = 'Pregnant';
            } elseif ($insemination->is_successful === false) {
                $cow->status = 'Active';
            } else {
                $cow->status = 'Inseminated';
            }
            $cow->saveQuietly();
        }

        // Reduce Semen Stock
        if ($insemination->semen_stock_id) {
            $stock = $insemination->semenStock;
            if ($stock) {
                $stock->decrement('remaining_quantity', $insemination->straws_used);
            }
        }
    }

    public function updated(Insemination $insemination): void
    {
        if ($insemination->isDirty('is_successful')) {
            $cow = $insemination->cow;
            if ($cow) {
                if ($insemination->is_successful === true) {
                    $cow->status = 'Pregnant';
                } elseif ($insemination->is_successful === false) {
                    $cow->status = 'Active';
                }
                $cow->saveQuietly();
            }
        }

        // Handle Semen Stock or Straw Quantity Change
        if ($insemination->isDirty(['semen_stock_id', 'straws_used'])) {
            $oldStockId = $insemination->getOriginal('semen_stock_id');
            $newStockId = $insemination->semen_stock_id;
            $oldStraws = $insemination->getOriginal('straws_used') ?? 1;
            $newStraws = $insemination->straws_used;

            // If stock changed
            if ($oldStockId !== $newStockId) {
                if ($oldStockId) {
                    $oldStock = \App\Models\SemenStock::find($oldStockId);
                    if ($oldStock) $oldStock->increment('remaining_quantity', $oldStraws);
                }

                if ($newStockId) {
                    $newStock = $insemination->semenStock;
                    if ($newStock) $newStock->decrement('remaining_quantity', $newStraws);
                }
            } 
            // If only straws quantity changed for the same stock
            elseif ($newStockId && $oldStraws !== $newStraws) {
                $stock = $insemination->semenStock;
                if ($stock) {
                    $diff = $newStraws - $oldStraws;
                    if ($diff > 0) {
                        $stock->decrement('remaining_quantity', $diff);
                    } else {
                        $stock->increment('remaining_quantity', abs($diff));
                    }
                }
            }
        }
    }

    /**
     * Handle the Insemination "deleted" event.
     */
    public function deleted(Insemination $insemination): void
    {
        if ($insemination->semen_stock_id) {
            $stock = $insemination->semenStock;
            if ($stock) {
                $stock->increment('remaining_quantity', $insemination->straws_used);
            }
        }
    }

    /**
     * Handle the Insemination "restored" event.
     */
    public function restored(Insemination $insemination): void
    {
        //
    }

    /**
     * Handle the Insemination "force deleted" event.
     */
    public function forceDeleted(Insemination $insemination): void
    {
        //
    }
}
