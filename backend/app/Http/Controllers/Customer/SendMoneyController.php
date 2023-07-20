<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class SendMoneyController extends Controller
{
    public function send_money(Request $request)
    {
        $auth_user = auth()->user();
        $v = Validator::make($request->all(), [
            'amount' => 'required',
            'description' => 'required',
            'currency' => 'required',
            'recipient' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }
        //Check Balance
        $received = $auth_user->transactions()->where('process', 'credit')->where('status', 'approved')->sum('amount');
        $sent = $auth_user->transactions()->where('process', 'debit')->where('status', 'approved')->sum('amount');
        $balance_from_transaction_history = floatval($received) - floatval($sent);
        $stored_balance = $auth_user->account_details->balance($request->currency);
        if ($stored_balance != $balance_from_transaction_history) {
            return response()->json([
                'status' => false,
                'message' => 'Your balance and transaction balance does not match',
            ], 400);
        }
        // Add Fee
        $charge = 0;
        if ($stored_balance < $request->amount) {
            return response()->json([
                'status' => false,
                'message' => 'Insufficient Fund, Try making a deposit',
            ], 400);

        }
        // Find Recipient
        $user = User::where('email', $request->recipient)->orWhere('account_number', $request->recipient)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Account Number or Email not correct',
            ], 400);
        }

        if ($auth_user->email == $user->email) {
            return response()->json([
                'status' => false,
                'message' => 'You cant send money to yourself, try the deposit tab',
            ], 400);
        }

        DB::beginTransaction();

        $trans_ref = Helper::generate_trans_ref(auth()->user()->id);
        $transaction = auth()->user()->transactions()->create([
            'currency' => $request['currency'],
            'amount' => $request['amount'],
            'fee' => $charge,
            'process' => 'debit',
            'method' => 'online',
            'type' => 'send_money',
            'status' => 'awaiting_otp',
            'transaction_ref' => $trans_ref,
            'description' => $request['description'],
            'notify' => "You are sending " . $request['currency'] . " " . $request['amount'] . " to " . $user->email,
            'receiver_id' => $user->id,
        ]);
        //EMAIL_REQUIRED

        $otp = Helper::generate_otp();
        $auth_user->otps()->create([
            'code' => $otp,
            'expires_at' => now()->addMinutes(15),
            'trans_id' => $transaction->id,
            'use' => 'transaction',
        ]);
        //EMAIL_REQUIRED

//Create Debit Transactions
        // $debit = new Transaction();
//         $debit->user_id = auth()->id();
//         $debit->currency_id = $request->input('currency_id');
//         $debit->amount = $request->input('amount') + $charge;
//         $debit->fee = $charge;
//         $debit->dr_cr = 'dr';
//         $debit->type = 'Transfer';
//         $debit->method = 'Online';
//         $debit->status = $status;
//         $debit->note = $request->input('note');
//         $debit->created_user_id = auth()->id();
//         $debit->branch_id = auth()->user()->branch_id;

//         $debit->save();

// //Create Credit Transactions
//         $credit = new Transaction();
//         $credit->user_id = $user->id;
//         $credit->currency_id = $request->input('currency_id');
//         $credit->amount = $request->input('amount');
//         $credit->dr_cr = 'cr';
//         $credit->type = 'Transfer';
//         $credit->method = 'Online';
//         $credit->status = $status;
//         $credit->note = $request->input('note');
//         $credit->created_user_id = auth()->id();
//         $credit->branch_id = auth()->user()->branch_id;
//         $credit->parent_id = $debit->id;

//         $credit->save();

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Sending Money is Sweet',
            "balance_from_transaction_history" => $balance_from_transaction_history,
            "received" => $auth_user->account_details->balance($request->currency),
        ], 200);

    }
}
