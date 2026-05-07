<?php

namespace Tests\Feature;

use App\Models\Cow;
use App\Models\Feed;
use App\Models\FeedAllocation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_inventory_deduction_on_allocation()
    {
        $feed = Feed::create(['name' => 'Corn Silage', 'quantity_in_stock' => 1000, 'cost_per_kg' => 0.5]);
        $cow = Cow::create(['tag_number' => 'C1', 'dob' => '2020-01-01', 'gender' => 'Female']);

        // Allocate 50kg
        FeedAllocation::create([
            'feed_id' => $feed->id,
            'cow_id' => $cow->id,
            'amount' => 50,
            'date' => now(),
        ]);

        // Expect 950kg
        $this->assertEquals(950, $feed->fresh()->quantity_in_stock);
    }

    public function test_inventory_restore_on_deletion()
    {
        $feed = Feed::create(['name' => 'Hay', 'quantity_in_stock' => 500, 'cost_per_kg' => 0.2]);
        $allocation = FeedAllocation::create([
            'feed_id' => $feed->id,
            'amount' => 100,
            'date' => now(),
        ]);

        $this->assertEquals(400, $feed->fresh()->quantity_in_stock);

        // Delete allocation
        $allocation->delete();

        // Expect 500kg
        $this->assertEquals(500, $feed->fresh()->quantity_in_stock);
    }
}
