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

        $withdraw_ref = Helper::generate_deposit_ref($user->id);
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
            'process' => 'debit',
            'method' => 'manual',
            'type' => 'withdraw',
            'status' => 'approved',
            'transaction_ref' => $trans_ref,
            'description' => $request['description'],
            'withdraw_ref' => $withdraw_ref,
            'notify' => "Admin made a deposit to your account",
        ]);
        $user->account_details->add_balance($request['amount'], $request['currency']);

        Mail::to($user)->send(new TransactionMail($transaction, $user));

        return response()->json(['status' => true, 'message' => "Deposit Requested successfully"]);

    }
    public function list_withdraw_request()
    {

        $withdraw_requests = WithdrawRequest::select('withdraw_requests.*')
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
    public function list_withdraw_request_transaction()
    {

        $transactions = Transaction::select('transactions.*')
            ->with('user')
            ->where('type', 'withdraw')->orderBy("transactions.created_at", "desc");

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
