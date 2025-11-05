<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Command;

class GenerateTicketProcessed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:generate_processed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate dummy data tickets processed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ticket = Ticket::factory()->create([
            'status' => true,
            'processed_at' => now(),
        ]);

        $this->info("Generate ticket processed #{$ticket->id}");
        return self::SUCCESS;

    }
}
