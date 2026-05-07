<?php

namespace Tests\Feature;

use App\Models\Cow;
use App\Models\Insemination;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InseminationTest extends TestCase
{
    use RefreshDatabase;

    public function test_insemination_updates_cow_status_to_inseminated()
    {
        $cow = Cow::create([
            'tag_number' => 'C1',
            'dob' => '2020-01-01',
            'gender' => 'Female',
            'status' => 'Active'
        ]);

        Insemination::create([
            'cow_id' => $cow->id,
            'date' => now(),
            'type' => 'Artificial Insemination',
            'cost' => 50,
        ]);

        $this->assertEquals('Inseminated', $cow->fresh()->status);
    }

    public function test_successful_insemination_updates_cow_status_to_pregnant()
    {
        $cow = Cow::create([
            'tag_number' => 'C1',
            'dob' => '2020-01-01',
            'gender' => 'Female',
            'status' => 'Inseminated'
        ]);

        $insemination = Insemination::create([
            'cow_id' => $cow->id,
            'date' => now(),
            'type' => 'Artificial Insemination',
            'cost' => 50,
        ]);

        $insemination->update(['is_successful' => true]);

        $this->assertEquals('Pregnant', $cow->fresh()->status);
    }

    public function test_failed_insemination_reverts_cow_status_to_active()
    {
        $cow = Cow::create([
            'tag_number' => 'C1',
            'dob' => '2020-01-01',
            'gender' => 'Female',
            'status' => 'Inseminated'
        ]);

        $insemination = Insemination::create([
            'cow_id' => $cow->id,
            'date' => now(),
            'type' => 'Artificial Insemination',
            'cost' => 50,
        ]);

        $insemination->update(['is_successful' => false]);

        $this->assertEquals('Active', $cow->fresh()->status);
    }
}
