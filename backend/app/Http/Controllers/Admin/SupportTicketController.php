<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\User;
use App\Services\Helper;
use Illuminate\Http\Request;
use Validator;

class SupportTicketController extends Controller
{
    public function create_ticket(Request $request)
    {
        $v = Validator::make($request->all(), [
            'subject' => 'required',
            'description' => 'required',
            'user' => 'required',
            'priority' => 'required',
            'status' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $user = User::where('id', request('user'))->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => "Can not Find User"]);
        }

        $attachment = "";
        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $attachment = time() . $file->getClientOriginalName();
            $file->move(public_path() . "/uploads/support_ticket/", $attachment);
        }

        $ticket_ref = Helper::generate_ticket_ref();

        $ticket = $user->support_tickets()->create([
            'ticket_ref' => $ticket_ref,
            'priority' => request('priority'),
            'description' => request('description'),
            'subject' => request('subject'),
            'status' => request('status') == 'open' ? 'active' : 'pending',
            'admin_id' => auth()->user()->id,
            "attachment" => $attachment,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Ticket Created Successfully",
            'data' => $ticket,
        ], 200);

    }
    public function list_tickets()
    {
        $support_tickets = SupportTicket::orderBy('created_at')->join('users', 'support_tickets.user_id', 'users.id')->select('support_tickets.*', 'users.name', 'users.email')->get();
        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'support_tickets' => $support_tickets,
        ], 200);

    }
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
