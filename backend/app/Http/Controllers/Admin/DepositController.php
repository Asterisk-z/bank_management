<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TransactionMail;
use App\Models\DepositRequest;
use App\Models\Transaction;
use App\Models\User;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;

class DepositController extends Controller
{
    public function create_deposit(Request $request)
    {
        $v = Validator::make($request->all(), [
            'amount' => 'required',
            'user' => 'required',
            'description' => '',
            'currency' => 'required',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $user = User::where('id', request('user'))->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'errors' => "User Not Found",
            ], 422);

        }

        $deposit_ref = Helper::generate_deposit_ref($user->id);
        $user->deposit_requests()->create([
            'method' => 'online',
            'amount' => $request['amount'],
            'currency' => $request['currency'],
            'description' => $request['description'],
            'deposit_ref' => $deposit_ref,
            'status' => 'approved',
        ]);

        $trans_ref = Helper::generate_trans_ref($user->id);

        $transaction = $user->transactions()->create([
            'currency' => $request['currency'],
            'amount' => $request['amount'],
            'fee' => 0.00,
            'process' => 'credit',
            'method' => 'manual',
            'type' => 'deposit',
            'status' => 'approved',
            'transaction_ref' => $trans_ref,
            'description' => $request['description'],
            'deposit_ref' => $deposit_ref,
            'notify' => "Admin made a deposit to your account",
        ]);
        $user->account_details->add_balance($request['amount'], $request['currency']);

        Mail::to($user)->send(new TransactionMail($transaction, $user));

        return response()->json(['status' => true, 'message' => "Deposit Requested successfully"]);

    }
    public function list_user(Request $request)
    {
        $users = User::where('status', 'active')->where('user_type', 'customer')->get();

        return response()->json([
            'status' => true,
            'users' => $users,
        ], 200);

    }
    public function list_deposit_transaction(Request $request)
    {
        $deposit_request = Transaction::where('type', 'deposit')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select('users.email', 'users.name', 'transactions.*')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'deposit_request' => $deposit_request,
        ], 200);

    }
    public function list_deposit_transaction_approved(Request $request)
    {
        $deposit_request = Transaction::where('type', 'deposit')
            ->where('transactions.status', 'approved')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select('users.email', 'users.name', 'transactions.*')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'deposit_request' => $deposit_request,
        ], 200);

    }
    public function list_deposit_transaction_pending(Request $request)
    {
        $deposit_request = Transaction::where('type', 'deposit')
            ->whereIn('transactions.status', ['pending', 'awaiting_otp'])
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select('users.email', 'users.name', 'transactions.*')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'deposit_request' => $deposit_request,
        ], 200);

    }
    public function list_deposit_transaction_declined(Request $request)
    {
        $deposit_request = Transaction::where('type', 'deposit')
            ->whereIn('transactions.status', ['declined', 'canceled'])
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select('users.email', 'users.name', 'transactions.*')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'deposit_request' => $deposit_request,
        ], 200);

    }
    public function list_deposit(Request $request)
    {
        $deposit_request = DepositRequest::join('users', 'deposit_requests.user_id', '=', 'users.id')
            ->select('users.email', 'users.name', 'deposit_requests.*')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'deposit_request' => $deposit_request,
        ], 200);

    }
    public function list_deposit_pending(Request $request)
    {
        $deposit_request = DepositRequest::where('deposit_requests.status', 'pending')
            ->join('users', 'deposit_requests.user_id', '=', 'users.id')
            ->select('users.email', 'users.name', 'deposit_requests.*')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'deposit_request' => $deposit_request,
        ], 200);

    }
    public function list_deposit_approved(Request $request)
    {
        $deposit_request = DepositRequest::where('deposit_requests.status', 'approved')
            ->join('users', 'deposit_requests.user_id', '=', 'users.id')
            ->select('users.email', 'users.name', 'deposit_requests.*')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'deposit_request' => $deposit_request,
        ], 200);
    }
    public function list_deposit_canceled(Request $request)
    {
        $deposit_request = DepositRequest::where('deposit_requests.status', 'declined')
            ->join('users', 'deposit_requests.user_id', '=', 'users.id')
            ->select('users.email', 'users.name', 'deposit_requests.*')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'deposit_request' => $deposit_request,
        ], 200);
    }
    public function approved_deposit(Request $request)
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

        $payment_request = DepositRequest::where('id', request('id'))->first();
        if (!$payment_request) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to approve',
            ], 200);

        }
        if ($payment_request->status == 'approved') {
            return response()->json([
                'status' => false,
                'message' => 'Deposit Already Approved',
            ], 200);
        }

        $user = User::where('id', $payment_request->user_id)->first();

        $trans_ref = Helper::generate_trans_ref($user->id);

        $payment_request->status = 'approved';

        $payment_request->save();

        $transaction = $user->transactions()->create([
            'currency' => $payment_request->currency,
            'amount' => $payment_request->amount,
            'fee' => 0.00,
            'process' => 'credit',
            'method' => $payment_request->method,
            'type' => 'deposit',
            'status' => 'approved',
            'transaction_ref' => $trans_ref,
            'description' => $payment_request->description,
            'deposit_ref' => $payment_request->deposit_ref,
            'notify' => "Admin approved your deposit request",
        ]);
        $user->account_details->add_balance($payment_request->amount, $payment_request->currency);

        Mail::to($user)->send(new TransactionMail($transaction, $user));

        return response()->json([
            'status' => true,
            'message' => 'Upload',
        ], 200);

    }
    public function cancel_deposit(Request $request)
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

        $payment_request = DepositRequest::where('id', request('id'))->first();
        if (!$payment_request) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to approve',
            ], 200);

        }
        if ($payment_request->status == 'approved') {
            return response()->json([
                'status' => false,
                'message' => 'Deposit Already Approved',
            ], 200);
        }

        $user = User::where('id', $payment_request->user_id)->first();

        $payment_request->status = 'declined';

        $payment_request->save();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
        ], 200);

    }
}
