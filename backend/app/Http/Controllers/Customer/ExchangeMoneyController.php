<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\User;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class ExchangeMoneyController extends Controller
{
    public function exchange(Request $request)
    {
        $auth_user = auth()->user();
        $v = Validator::make($request->all(), [
            'amount' => 'required',
            'description' => 'required',
            'currency' => 'required',
            'xCurrency' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $currency = Currency::where('name', request('currency'))->first();
        $currencytwo = Currency::where('name', request('xCurrency'))->first();
        $amount = $request->amount;
        $newAmount = (floatval(request('amount')) / $currency->rate) * $currencytwo->rate;

        //Check Balance
        $received = $auth_user->transactions()->where('process', 'credit')->where('status', 'approved')->where('currency', request('currency'))->sum('amount');
        $sent = $auth_user->transactions()->where('process', 'debit')->where('status', 'approved')->where('currency', request('currency'))->sum('amount');
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

        DB::beginTransaction();

        $trans_ref = Helper::generate_trans_ref(auth()->user()->id);
        $transaction = auth()->user()->transactions()->create([
            'currency' => $request['currency'],
            'amount' => $request['amount'],
            'fee' => $charge,
            'process' => 'debit',
            'method' => 'online',
            'type' => 'exchange',
            'status' => 'awaiting_otp',
            'transaction_ref' => $trans_ref,
            'description' => $request['description'],
            'notify' => "You are converting your " . $request['currency'] . " to " . $request['xCurrency'],
            'x_currency' => $request['xCurrency'],
            'x_amount' => $newAmount,
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

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Exchange Money Is been processed ',
        ], 200);

    }
}
