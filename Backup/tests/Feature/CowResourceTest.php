<?php

namespace Tests\Feature;

use App\Filament\Resources\Cows\Pages\CreateCow;
use App\Filament\Resources\Cows\Pages\EditCow;
use App\Filament\Resources\Cows\Pages\ListCows;
use App\Models\Cow;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CowResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_page()
    {
        $user = User::factory()->create(['role' => 'Admin']);
        $this->actingAs($user)->get(ListCows::getUrl())->assertSuccessful();
    }

    public function test_can_create_cow()
    {
        $user = User::factory()->create(['role' => 'Admin']);
        
        Livewire::actingAs($user)
            ->test(CreateCow::class)
            ->fillForm([
                'tag_number' => 'TEST001',
                'name' => 'Bella',
                'dob' => '2020-01-01',
                'gender' => 'Female',
                'status' => 'Active',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('cows', [
            'tag_number' => 'TEST001',
            'name' => 'Bella',
        ]);
    }

    public function test_validation_requires_tag_number()
    {
        $user = User::factory()->create(['role' => 'Admin']);

        Livewire::actingAs($user)
            ->test(CreateCow::class)
            ->fillForm([
                'tag_number' => '', // Empty
                'dob' => '2020-01-01',
            ])
            ->call('create')
            ->assertHasFormErrors(['tag_number' => 'required']);
    }

    public function test_can_update_cow()
    {
        $user = User::factory()->create(['role' => 'Admin']);
        $cow = Cow::create([
            'tag_number' => 'OLD001', 
            'dob' => '2021-01-01',
            'gender' => 'Female',
            'status' => 'Active'
        ]);

        Livewire::actingAs($user)
            ->test(EditCow::class, ['record' => $cow->getKey()])
            ->fillForm([
                'name' => 'Updated Name',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('cows', [
            'tag_number' => 'OLD001',
            'name' => 'Updated Name',
        ]);
    }

    public function test_can_delete_cow()
    {
        $user = User::factory()->create(['role' => 'Admin']);
        $cow = Cow::create([
            'tag_number' => 'DEL001', 
            'dob' => '2021-01-01', 
            'gender' => 'Female',
            'status' => 'Active'
        ]);

        Livewire::actingAs($user)
            ->test(ListCows::class)
            ->callTableAction('delete', $cow);

        $this->assertModelMissing($cow);
    }
}
