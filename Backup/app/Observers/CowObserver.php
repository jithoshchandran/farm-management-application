<?php

namespace App\Observers;

use App\Models\Cow;

class CowObserver
{
    /**
     * Handle the Cow "updated" event.
     */
    public function updated(Cow $cow): void
    {
        if ($cow->isDirty('last_calving_date') && $cow->last_calving_date) {
            $cow->breeding_cycle += 1;
            $cow->status = 'Lactating';
            $cow->saveQuietly();
        }
    }
}
