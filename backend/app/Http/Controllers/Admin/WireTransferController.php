<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\WireTransferNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;

class WireTransferController extends Controller
{

    public function list_wire_transfer(Request $request)
    {
        $wire_transfers = Transaction::where('transactions.type', 'wire_transfer')->where('transactions.status', '<>', 'awaiting_otp')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select('users.email', 'users.name', 'transactions.*')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'wire_transfers' => $wire_transfers,
        ], 200);
    }
    public function list_pending_wire_transfer()
    {
        $wire_transfers = Transaction::where('transactions.type', 'wire_transfer')
            ->where('transactions.status', 'pending')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select('users.email', 'users.name', 'transactions.*')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'wire_transfers' => $wire_transfers,
        ], 200);

    }
    public function list_approved_wire_transfer()
    {

        $wire_transfers = Transaction::where('transactions.type', 'wire_transfer')
            ->where('transactions.status', 'approved')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select('users.email', 'users.name', 'transactions.*')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'wire_transfers' => $wire_transfers,
        ], 200);
    }
    public function list_rejected_wire_transfer()
    {
        $wire_transfers = Transaction::where('transactions.type', 'wire_transfer')
            ->whereIn('transactions.status', ['declined', 'canceled'])
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select('users.email', 'users.name', 'transactions.*')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'wire_transfers' => $wire_transfers,
        ], 200);

    }
    public function cancel_wire_transfer(Request $request)
    {

        $v = Validator::make($request->all(), [
            'id' => 'required',
            'user' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $transaction = Transaction::where('id', request('id'))->first();
        $user = User::where('id', request('user'))->first();

        $transaction->status = 'canceled';
        $transaction->save();

        Mail::send('emails.status', ['messages' => "Your Wire Transfer Request  with reference no. " . $transaction->transaction_ref . "  was declined", 'firstName' => $user->name, 'subject' => "Wire Transfer Declined"], function ($message) use ($request, $user) {
            $message->to($user->email);
            $message->subject("Wire Transfer Declined");
        });

        $user->account_details->add_balance($transaction->amount, $transaction->currency);

        $user->notify(new WireTransferNotification("Your Wire Transfer Request  with reference no. " . $transaction->transaction_ref . " was declined"));

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            "trans" => $transaction,
        ], 200);
    }
    public function approve_wire_transfer(Request $request)
    {

        $v = Validator::make($request->all(), [
            'id' => 'required',
            'user' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $transaction = Transaction::where('id', request('id'))->first();
        $user = User::where('id', request('user'))->first();

        $transaction->status = 'approved';
        $transaction->save();

        Mail::send('emails.status', ['messages' => "Your Wire Transfer Request of  " . $transaction->currency . " " . $transaction->amount . " to " . $transaction->account_holder . "  with reference no. " . $transaction->transaction_ref . " is completed successfully  ", 'firstName' => $user->name, 'subject' => "Wire Transfer Completed"], function ($message) use ($request, $user) {
            $message->to($user->email);
            $message->subject("Wire Transfer Completed");
        });

        $user->notify(new WireTransferNotification("Your Wire Transfer Request  with reference no. " . $transaction->transaction_ref . " is completed successfully "));

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            "trans" => $transaction,
            'user' => $user,
        ], 200);
    }
}
