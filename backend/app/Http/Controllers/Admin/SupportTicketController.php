<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Validator;

class SupportTicketController extends Controller
{
    public function make_active(Request $request)
    {

        $auth_user = auth()->user();
        $v = Validator::make($request->all(), [
            'ticket_id' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $ticket = SupportTicket::where('id', request('ticket_id'))->first();
        $ticket->status = 'active';
        $ticket->admin_id = $auth_user->id;
        $ticket->save();

        return response()->json([
            'status' => true,
            'message' => "Ticket Activated Successfully",
        ], 200);

    }

    public function close_ticket(Request $request)
    {

        $auth_user = auth()->user();
        $v = Validator::make($request->all(), [
            'ticket_id' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $ticket = SupportTicket::where('id', request('ticket_id'))->first();
        $ticket->status = 'close';
        $ticket->closed_user_id = $auth_user->id;
        $ticket->save();

        return response()->json([
            'status' => true,
            'message' => "Ticket Closed Successfully",
            'data' => auth()->user()->support_tickets,
        ], 200);

    }
}
