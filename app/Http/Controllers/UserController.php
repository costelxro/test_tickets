<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function user_tickets(Request $request, string $user_email): JsonResponse
    {
        $request->validate(['per_page' => 'integer|min:1|max:50']);
        $email = urldecode($user_email);
        $resp = Ticket::where('user_email', $email)
            ->orderByDesc('created_at')
            ->paginate($request->integer('per_page', 10));
        return response()->json($resp);
    }

    public function create_tickets(Request $request, string $user_email): JsonResponse
    {
        $email = urldecode($user_email);

        $data = $request->validate([
            'subject'   => 'required|string|max:255',
            'content'   => 'required|string',
            'user_name' => 'required|string|max:255',
            'priority'  => 'required|integer',
        ]);

        try {
            $ticket = Ticket::create([
                'subject'     => $data['subject'],
                'content'     => $request->input('content'),
                'user_name'   => $data['user_name'],
                'user_email'  => $email,
                'priority'    => (int) $data['priority'],
                'status'      => false,
            ]);

            return response()->json($ticket, 201);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Unable to create ticket'], 500);
        }
    }


}
