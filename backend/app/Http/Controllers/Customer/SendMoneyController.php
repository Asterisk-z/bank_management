<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\OTPMail;
use App\Models\User;
use App\Notifications\SendMoneyNotification;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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

        if (!$auth_user->account_details->can_make_withdrawal()) {
            return response()->json([
                'status' => false,
                'message' => 'Your account has been restricted and cannot process transactions at the moment. Please contact our support team for further assistance.',
            ], 400);

        }
        //Check Balance
        $received = $auth_user->transactions()->where('process', 'credit')->whereIn('status', ['approved', 'pending'])->where('currency', request('currency'))->sum('amount');
        $sent = $auth_user->transactions()->where('process', 'debit')->whereIn('status', ['approved', 'pending'])->where('currency', request('currency'))->sum('amount');
        $balance_from_transaction_history = round(floatval($received) - floatval($sent), 2);
        $stored_balance = $auth_user->account_details->balance(request('currency'));
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
            'notify' => "You are sending " . $request['currency'] . " " . number_format($request['amount'], 2) . " to " . $user->email,
            'receiver_id' => $user->id,
        ]);

        $otp_code = Helper::generate_otp();
        $otp = $auth_user->otps()->create([
            'code' => $otp_code,
            'expires_at' => now()->addMinutes(15),
            'trans_id' => $transaction->id,
            'use' => 'transaction',
        ]);

        Mail::to(auth()->user())->send(new OTPMail($otp, auth()->user()));
        auth()->user()->notify(new SendMoneyNotification($transaction->notify));

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Sending Money Is been processed ',
        ], 200);

    }

    public function send_money_history()
    {
        return response()->json([
            'status' => true,
            'message' => 'Sending Money Is been processed ',
            'data' => auth()->user()->transactions()->where('type', 'send_money')->take(8)->get(),
        ], 200);

    }
}
