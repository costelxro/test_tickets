<?php

namespace Tests\Feature;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketsIndexTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_index_validation_per_page(): void
    {
        Ticket::factory()->count(25)->create();
        $this->getJson('/tickets')
            ->assertOk()
            ->assertJsonStructure(['data','links']);

        $this->getJson('/tickets?per_page=abc')
            ->assertStatus(422); // to fail

        $this->getJson('/tickets?per_page=5')
            ->assertOk()
            ->assertJsonCount(5,['data'])
            ->assertJsonStructure(['data','links']);

        $this->getJson('/tickets?per_page=12')
            ->assertOk()
            ->assertJsonCount(12,['data'])
            ->assertJsonStructure(['data','links']);

        $this->getJson('/tickets')
            ->assertOk()
            ->assertJsonStructure(['data','links'])
            ->assertJsonCount(10, 'data');
    }

}
