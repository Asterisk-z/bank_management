<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\TransactionMail;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Validator;

class WithdrawalController extends Controller
{
    //
    public function withdraw(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currency' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }
        $user = auth()->user();
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

        DB::beginTransaction();

        $withdraw_ref = Helper::generate_deposit_ref($user->id);
        $user->withdraw_requests()->create([
            'withdraw_ref' => $withdraw_ref,
            'method_id' => 1,
            'amount' => $request['amount'],
            'currency' => $request['currency'],
            'description' => $request['description'],
            'status' => 'pending',
        ]);

        $trans_ref = Helper::generate_trans_ref($user->id);

        $transaction = $user->transactions()->create([
            'currency' => $request['currency'],
            'amount' => $request['amount'],
            'fee' => 0.00,
            'process' => 'debit',
            'method' => 'manual',
            'type' => 'withdraw',
            'status' => 'pending',
            'transaction_ref' => $trans_ref,
            'description' => $request['description'],
            'withdraw_ref' => $withdraw_ref,
            'notify' => "You Withdraw " . $request['currency'] . " " . $request['amount'] . " from your account",
        ]);
        $user->account_details->sub_balance($request['amount'], $request['currency']);

        Mail::to($user)->send(new TransactionMail($transaction, $user));

        DB::commit();

        return response()->json(['status' => true, 'message' => "Withdrawal Sent Successful"]);

    }

    public function withdraw_requests()
    {

        return response()->json(['status' => true, 'message' => "Withdrawal Sent Successful", "withdraw_requests" => auth()->user()->withdraw_requests]);

    }
}
