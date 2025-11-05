<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Command;

class GenerateTicket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate dummy data tickets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ticket = Ticket::factory()->create([
            'status' => false
        ]);

        $this->info("Generate ticket #{$ticket->id}");
        return self::SUCCESS;

    }
}
