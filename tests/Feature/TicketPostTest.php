<?php

namespace Tests\Feature;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketPostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_ticket_post(): void
    {
        $email = 'test@user.test';

        $data = [
            'subject'   => 'Test Subject',
            'content'   => 'content bla bla',
            'user_name' => 'Costel Nicolea',
            'priority'  => '4',
        ];

        $this->postJson("/users/$email/create", $data)
            ->assertStatus(201)
            ->assertJson($data);

        $this->assertDatabaseHas('tickets', [
            'user_email' => $email,
            'subject' => 'Test Subject',
        ]);

        Ticket::factory()->count(25)->create();

    }

}
