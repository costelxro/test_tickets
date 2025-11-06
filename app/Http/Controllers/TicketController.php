<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate(['per_page' => 'integer|min:1|max:50']);
        $tickets = Ticket::orderByDesc('created_at')->paginate($request->integer('per_page', 10));
        return response()->json($tickets);
    }

    public function open(Request $request): JsonResponse
    {
        $request->validate(['per_page' => 'integer|min:1|max:50']);
        $open_tickets = Ticket::where('status', true)->orderByDesc('created_at')
            ->paginate($request->integer('per_page', 10));
        return response()->json($open_tickets);

    }

    public function closed(Request $request) : JsonResponse
    {
        $request->validate(['per_page' => 'integer|min:1|max:50']);
        $closed_tickets = Ticket::where('status', false)->orderByDesc('created_at')
            ->paginate($request->integer('per_page', 10));
        return response()->json($closed_tickets);
    }

}
