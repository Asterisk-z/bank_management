<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TransactionMail;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WithdrawRequest;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Validator;

class WithdrawController extends Controller
{
    //

    public function create_withdraw(Request $request)
    {
        $v = Validator::make($request->all(), [
            'date' => 'required',
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

        if (!$user->account_details->can_make_withdrawal()) {
            return response()->json([
                'status' => false,
                'message' => 'User account has been restricted and cannot process transactions at the moment. Please contact our support team for further assistance.',
            ], 400);

        }

        $received = $user->transactions()->where('process', 'credit')->whereIn('status', ['approved', 'pending'])->where('currency', request('currency'))->sum('amount');
        $sent = $user->transactions()->where('process', 'debit')->whereIn('status', ['approved', 'pending'])->where('currency', request('currency'))->sum('amount');
        $balance_from_transaction_history = round(floatval($received) - floatval($sent), 2);
        $stored_balance = $user->account_details->balance(request('currency'));
        if ($stored_balance != $balance_from_transaction_history) {
            return response()->json([
                'status' => false,
                'stored_balance' => $stored_balance,
                'balance_from_transaction_history' => $balance_from_transaction_history,
                'message' => 'User  balance and transaction balance does not match',
            ], 400);
        }

        if ($stored_balance < $request->amount) {
            return response()->json([
                'status' => false,
                'message' => 'Insufficient Fund, Try making a deposit',
            ], 400);

        }

        $withdraw_ref = Helper::generate_deposit_ref($user->id);
        $user->withdraw_requests()->create([
            'withdraw_ref' => $withdraw_ref,
            'method_id' => 1,
            'amount' => $request['amount'],
            'currency' => $request['currency'],
            'description' => $request['description'],
            'status' => 'approved',
        ]);

        $trans_ref = Helper::generate_trans_ref($user->id);

        $transaction = $user->transactions()->create([
            'currency' => $request['currency'],
            'amount' => $request['amount'],
            'fee' => 0.00,
            'process' => 'debit',
            'method' => 'manual',
            'type' => 'withdraw',
            'status' => 'approved',
            'transaction_ref' => $trans_ref,
            'description' => $request['description'],
            'withdraw_ref' => $withdraw_ref,
            'notify' => "Admin made a Withdrawal from your account",
        ]);
        $user->account_details->sub_balance($request['amount'], $request['currency']);

        Mail::to($user)->send(new TransactionMail($transaction, $user));

        return response()->json(['status' => true, 'message' => "WIthdraw Requested successfully"]);
    }
    public function list_withdraw_request()
    {
        $withdraw_requests = WithdrawRequest::select('withdraw_requests.*', 'users.name', 'users.email')
            ->join('users', 'withdraw_requests.user_id', '=', 'users.id')
        // ->with('user')
            ->with('method')
            ->orderBy("withdraw_requests.id", "desc")->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'withdraw_requests' => $withdraw_requests,
        ], 200);

    }
    public function list_withdraw_request_approved()
    {
        $withdraw_requests = WithdrawRequest::select('withdraw_requests.*', 'users.name', 'users.email')->where('withdraw_requests.status', 'approved')
            ->join('users', 'withdraw_requests.user_id', '=', 'users.id')
        // ->with('user')
            ->with('method')
            ->orderBy("withdraw_requests.id", "desc")->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'withdraw_requests' => $withdraw_requests,
        ], 200);

    }
    public function list_withdraw_request_pending()
    {
        $withdraw_requests = WithdrawRequest::select('withdraw_requests.*', 'users.name', 'users.email')->where('withdraw_requests.status', 'pending')
            ->join('users', 'withdraw_requests.user_id', '=', 'users.id')

        // ->with('user')
            ->with('method')
            ->orderBy("withdraw_requests.id", "desc")->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'withdraw_requests' => $withdraw_requests,
        ], 200);

    }
    public function list_withdraw_request_declined()
    {
        $withdraw_requests = WithdrawRequest::select('withdraw_requests.*', 'users.name', 'users.email')->where('withdraw_requests.status', 'declined')
            ->join('users', 'withdraw_requests.user_id', '=', 'users.id')
        // ->with('user')
            ->with('method')
            ->orderBy("withdraw_requests.id", "desc")->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'withdraw_requests' => $withdraw_requests,
        ], 200);

    }
    public function list_withdraw_request_transaction()
    {

        $transactions = Transaction::where('type', 'withdraw')
            ->join('users', 'transactions.user_id', '=', 'users.id')
        // ->with('user')
            ->select('transactions.*', 'users.name', 'users.email')
            ->orderBy("transactions.created_at", "desc")->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'transactions' => $transactions,
        ], 200);

    }
    public function list_withdraw_request_transaction_approved()
    {

        $transactions = Transaction::where('transactions.type', 'withdraw')->where('transactions.status', 'approved')
            ->join('users', 'transactions.user_id', '=', 'users.id')
        // ->with('user')
            ->select('transactions.*', 'users.name', 'users.email')
            ->orderBy("transactions.created_at", "desc")->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'transactions' => $transactions,
        ], 200);

    }
    public function list_withdraw_request_transaction_pending()
    {

        $transactions = Transaction::where('transactions.type', 'withdraw')->where('transactions.status', 'pending')
            ->join('users', 'transactions.user_id', '=', 'users.id')
        // ->with('user')
            ->select('transactions.*', 'users.name', 'users.email')
            ->orderBy("transactions.created_at", "desc")->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'transactions' => $transactions,
        ], 200);

    }
    public function list_withdraw_request_transaction_declined()
    {

        $transactions = Transaction::where('transactions.type', 'withdraw')->whereIn('transactions.status', ['declined', 'canceled'])
            ->join('users', 'transactions.user_id', '=', 'users.id')
        // ->with('user')
            ->select('transactions.*', 'users.name', 'users.email')
            ->orderBy("transactions.created_at", "desc")->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'transactions' => $transactions,
        ], 200);

    }

    public function single_withdraw_request(Request $request)
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

        $withdraw_requests = WithdrawRequest::select('withdraw_requests.*')->where('id', request('id'))
            ->with('user')
            ->with('method')
            ->with('method.currency')
            ->orderBy("withdraw_requests.id", "desc");

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'withdraw_requests' => $withdraw_requests,
        ], 200);

    }

    public function approve_withdraw_request(Request $request)
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

        DB::beginTransaction();

        $withdrawRequest = WithdrawRequest::find(request('id'));
        $withdrawRequest->status = 'approved';
        $withdrawRequest->save();

        $transaction = Transaction::find($withdrawRequest->transaction_id);
        $transaction->status = 'approved';
        $transaction->save();

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'withdrawRequest' => $withdrawRequest,
        ], 200);

    }

    public function reject_withdraw_request(Request $request)
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

        DB::beginTransaction();

        $withdrawRequest = WithdrawRequest::find(request('id'));
        $withdrawRequest->status = 'declined';
        $withdrawRequest->save();

        $transaction = Transaction::find($withdrawRequest->transaction_id);
        $transaction->status = 'declined';
        $transaction->save();

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'withdrawRequest' => $withdrawRequest,
        ], 200);
    }
}
