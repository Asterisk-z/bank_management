<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Services\Helper;
use Illuminate\Http\Request;
use Validator;

class SupportTicketController extends Controller
{
    public function list_tickets()
    {
        return response()->json([
            'status' => true,
            'message' => "Ticket Created Successfully",
            'data' => auth()->user()->support_tickets,
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
        $ticket->status = 'closed';
        $ticket->closed_user_id = $auth_user->id;
        $ticket->save();

        return response()->json([
            'status' => true,
            'message' => "Ticket Closed Successfully",
            'data' => auth()->user()->support_tickets,
        ], 200);

    }
    public function find_ticket(Request $request)
    {
        $ticket = SupportTicket::where('ticket_ref', request('ticket_id'))->where('user_id', auth()->user()->id)->where('status', 'active')->first();
        if ($ticket) {
            return response()->json([
                'status' => true,
                'message' => "Ticket Found Successfully",
                'data' => $ticket,
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => "Ticket Found Successfully",
        ], 404);
    }
    public function create_ticket(Request $request)
    {
        $auth_user = auth()->user();
        $v = Validator::make($request->all(), [
            'subject' => 'required',
            'description' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $attachment = "";
        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $attachment = time() . $file->getClientOriginalName();
            $file->move(public_path() . "/uploads/support_ticket/", $attachment);
        }
        $ticket_ref = Helper::generate_ticket_ref();

        $ticket = $auth_user->support_tickets()->create([
            'ticket_ref' => $ticket_ref,
            'priority' => request('priority'),
            'description' => request('description'),
            'subject' => request('subject'),
            "attachment" => $attachment,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Ticket Created Successfully",
            'data' => $ticket,
        ], 200);

    }

}
