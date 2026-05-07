<?php

namespace App\Observers;

use App\Models\Treatment;

class TreatmentObserver
{
    /**
     * Handle the Treatment "created" event.
     */
    public function created(Treatment $treatment): void
    {
        // Update cow status to Sick if treatment starts
        if ($treatment->cow) {
            $treatment->cow->update(['status' => 'Sick']);
        }
    }

    /**
     * Handle the Treatment "updated" event.
     */
    public function updated(Treatment $treatment): void
    {
        // If status changes to Completed, revert cow status? 
        // Logic might be complex (what if multiple treatments?), simpler to just handle ACTIVE
        // For now, if we update withdrawal date, just ensure consistency.
    }
}
