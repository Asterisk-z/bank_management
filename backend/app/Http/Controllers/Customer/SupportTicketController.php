<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\TicketMessage;
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
        $ticket = SupportTicket::where('ticket_ref', request('ticket_id'))->first();
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

    public function send_message(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id' => 'required',
            'message' => 'required',
            'attachment' => '',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $ticket = SupportTicket::where('ticket_ref', request('id'))->where('status', '<>', 'pending')->first();
        if (!$ticket) {
            return response()->json([
                'status' => false,
                'message' => "Ticket Not Found",
            ], 200);

        }

        $attachment = "";
        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $attachment = time() . $file->getClientOriginalName();
            $file->move(public_path() . "/uploads/support_ticket_message/", $attachment);
            $ticket->attachment = $attachment;
        }

        // if ($ticket->status == 'closed') {
        //     $ticket->status = 'active';
        //     $ticket->save();
        // }

        $meaage = TicketMessage::create([
            "message" => $request->message,
            "attachment" => $attachment,
            "support_ticket_id" => $ticket->id,
            "sender_id" => auth()->user()->id,
            "receiver_id" => $ticket->admin_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Ticket Sent Successfully",
            'meaage' => $meaage,
        ], 200);

    }
    public function get_message(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $ticket = SupportTicket::where('ticket_ref', request('id'))->where('status', '<>', 'pending')->first();
        if (!$ticket) {
            return response()->json([
                'status' => false,
                'message' => "Ticket Not Found",
            ], 200);
        }

        $messages = TicketMessage::where('ticket_messages.support_ticket_id', $ticket->id)
            ->orderBy('ticket_messages.created_at')
            ->join('support_tickets', 'ticket_messages.support_ticket_id', 'support_tickets.id')
            ->join('users', 'ticket_messages.sender_id', 'users.id')
            ->select('ticket_messages.*', 'support_tickets.subject', 'users.name', 'users.profile_picture')->get();

        return response()->json([
            'status' => true,
            'message' => "Ticket Fetch Successfully",
            'messages' => $messages,
        ], 200);

    }

    public function single_chat_ticket_detail(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $ticket = SupportTicket::where('ticket_ref', request('id'))->where('status', '<>', 'pending')->with('user')->first();
        if (!$ticket) {
            return response()->json([
                'status' => false,
                'message' => "Ticket Not Found",
            ], 200);

        }

        return response()->json([
            'status' => true,
            'message' => "Ticket Updated Successfully",
            'ticket' => $ticket,
        ], 200);

    }

}
