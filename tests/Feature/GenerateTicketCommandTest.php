<?php
namespace Tests\Feature;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenerateTicketCommandTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_generate_ticket(): void
    {
        $this->assertEquals(0, Ticket::count());

        $this->artisan('tickets:generate')
            ->expectsOutputToContain('Generate ticket')
        ->assertExitCode(0);

        $this->assertEquals(1, Ticket::count());
        $ticket = Ticket::first();

        $this->assertNotEmpty($ticket->subject);
        $this->assertNotEmpty($ticket->content);
        $this->assertNotEmpty($ticket->user_name);
        $this->assertNotEmpty($ticket->user_email);
        $this->assertFalse($ticket->status);

    }
}
