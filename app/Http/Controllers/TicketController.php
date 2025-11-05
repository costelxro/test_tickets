<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        return Ticket::orderBy('created_at', 'desc')->paginate($request->integer('per_page', 10));
    }

    public function open(Request $request)
    {
        return Ticket::where('status', true)->paginate();
    }

    public function closed(Request $request)
    {
        return Ticket::where('status', false)->paginate();
    }

    public function user_ticket(Request $request, string $user_email)
    {
        $email = urldecode($user_email);
        return Ticket::where('user_email', $email)
            ->orderBy('created_at', 'desc')->paginate($request->integer('per_page', 10));
    }

    public function stats(Request $request) {

        $total_tickets = Ticket::count();
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
