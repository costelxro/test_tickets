<?php
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenerateTicketProcessedCommandTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_generate_ticket_processed(): void
    {
        $this->assertEquals(0, Ticket::count());

        $this->artisan('tickets:generate_processed')
            ->expectsOutputToContain('Generate ticket processed')
        ->assertExitCode(0);

        $this->assertEquals(1, Ticket::count());
        $ticket = Ticket::first();

        $this->assertNotEmpty($ticket->subject);
        $this->assertNotEmpty($ticket->content);
        $this->assertNotEmpty($ticket->user_name);
        $this->assertNotEmpty($ticket->user_email);
        $this->assertTrue($ticket->status);

    }
}
