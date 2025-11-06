<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketStatsController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
        $total_tickets = Ticket::count();
        $total_tickets_processed = Ticket::where('status', true)->count();
        $total_tickets_unprocessed = Ticket::where('status', false)->count();

        $user_name_of_highest_tickets = Ticket::select('user_name', 'user_email', DB::raw('COUNT(*) as count'))
            ->groupBy('user_name', 'user_email')
            ->orderBy('count', 'desc')
            ->first();

        $time_last_completed_ticket = Ticket::whereNotNull('processed_at')
            ->orderBy('processed_at', 'desc')
            ->value('processed_at');

        return response()->json([
            'total_tickets' => $total_tickets,
            'total_tickets_processed' => $total_tickets_processed,
            'total_tickets_unprocessed' => $total_tickets_unprocessed,
            'user_name_of_highest_tickets' => ([
                'user_email' => $user_name_of_highest_tickets->user_email,
                'user_name'  => $user_name_of_highest_tickets->user_name,
                'count' => (int) $user_name_of_highest_tickets->count,
            ]),
            'time_last_completed_ticket' => $time_last_completed_ticket,
        ]);

    }

}
