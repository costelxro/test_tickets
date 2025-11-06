<?php

namespace Tests\Unit;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        Ticket::factory()->count(20)->create(); // note: ->count(20), not factory(20)
        $res = $this->getJson('/tickets');
        $res->assertOk()
            ->assertJsonStructure(['data','links'])
            ->assertJsonCount(10, 'data');
    }

    public function test_open(): void
    {
        Ticket::factory()->count(2)->create(['status' => true]);

        $res = $this->getJson('/tickets/open');

        $res->assertOk();
        $res->assertJsonCount(2, 'data');
    }

    public function test_closed(): void
    {
        Ticket::factory()->count(2)->create(['status' => false]);

        $res = $this->getJson('/tickets/close');

        $res->assertOk();
        $res->assertJsonCount(2, 'data');
    }

    public function test_user_tickets(): void
    {
        $user_email = 'test_user@test.test';

        Ticket::factory()->count(1)->create(['user_email' => $user_email]);

        $res = $this->getJson('/users/'.rawurlencode($user_email).'/tickets');

        $res->assertOk();
        $res->assertJsonCount(1, 'data');
    }

//    public function test_priority():void
//    {
//        Ticket::factory()->count(10)->create(['priority' => 5]);
//
//        $res = $this->getJson('/tickets/priority/5');
//
//
//
//    }

    public function test_stats(): void
    {
        Ticket::factory()->count(10)->create(['status' => false]);

        Ticket::factory()->count(5)->create([
            'status' => true,
            'processed_at' => now()->subMinutes(5),
        ]);

        Ticket::factory()->count(4)->create([
            'user_email' => 'test@test.test',
            'user_name'  => 'User name',
            'status' => true,
            'processed_at' => now()->subMinute(),
        ]);

        $res = $this->getJson('/stats');

        $res->assertOk()
            ->assertJsonStructure([
                'total_tickets',
                'total_tickets_unprocessed',
                'user_name_of_highest_tickets' =>  [
                    'user_email',
                    'user_name',
                    'count'
                ],
                'time_last_completed_ticket'
            ]);

        $json = $res->json();

        $this->assertEquals(19, $json['total_tickets']);
        $this->assertEquals(10, $json['total_tickets_unprocessed']);
        $this->assertEquals('test@test.test', $json['user_name_of_highest_tickets']['user_email']);
        $this->assertNotNull($json['time_last_completed_ticket']);
    }

}
