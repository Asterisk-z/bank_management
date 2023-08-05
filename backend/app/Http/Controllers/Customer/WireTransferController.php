<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\OTPMail;
use App\Models\Bank;
use App\Models\User;
use App\Notifications\WireTransferNotification;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Validator;

class WireTransferController extends Controller
{
    public function wire_transfer(Request $request)
    {
        $auth_user = auth()->user();
        $v = Validator::make($request->all(), [
            'amount' => 'required',
            'description' => 'required',
            'accountHolder' => 'required',
            'accountNumber' => 'required',
            'selectedBank' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }
        $bank = Bank::find($request->selectedBank);

        if (!$auth_user->account_details->can_make_withdrawal()) {
            return response()->json([
                'status' => false,
                'message' => 'Your account has been restricted and cannot process transactions at the moment. Please contact our support team for further assistance.',
            ], 400);

        }

        //Check Balance
        $received = $auth_user->transactions()->where('process', 'credit')->whereIn('status', ['approved', 'pending'])->where('currency', $bank->bank_currency)->sum('amount');
        $sent = $auth_user->transactions()->where('process', 'debit')->whereIn('status', ['approved', 'pending'])->where('currency', $bank->bank_currency)->sum('amount');
        $balance_from_transaction_history = round(floatval($received) - floatval($sent), 2);
        $stored_balance = $auth_user->account_details->balance($bank->bank_currency);
        if ($stored_balance != $balance_from_transaction_history) {
            return response()->json([
                'status' => false,
                "balance_from_transaction_history" => $balance_from_transaction_history,
                'stored_balance' => $stored_balance,
                'message' => 'Your balance and transaction balance does not match',
            ], 400);
        }

        // Add Fee
        $charge = $bank->fixed_charge;
        $charge += ($bank->charge_in_percentage / 100) * $request->amount;

        if ($request->amount < $bank->minimum_transfer_amount || $request->amount > $bank->maximum_transfer_amount) {
            return response()->json([
                'status' => false,
                'message' => 'Insufficient Fund, Try making a deposit',
            ], 400);

        }

        if ($stored_balance < $request->amount + $charge) {
            return response()->json([
                'status' => false,
                'message' => 'Insufficient Fund, Try making a deposit',
            ], 400);

        }

        DB::beginTransaction();
        $trans_ref = Helper::generate_trans_ref(auth()->user()->id);
        $transaction = auth()->user()->transactions()->create([
            'currency' => $bank->bank_currency,
            'amount' => $request->amount + $charge,
            'fee' => $charge,
            'process' => 'debit',
            'method' => 'manual',
            'type' => 'wire_transfer',
            'status' => 'awaiting_otp',
            'transaction_ref' => $trans_ref,
            'description' => $request['description'],
            'notify' => "You are sending your " . $bank->bank_currency . " " . $request->amount . "  to  " . $request->accountHolder,
            'account_holder' => $request->accountHolder,
            'account_number' => $request->accountNumber,
            'bank' => $bank->name,
        ]);
        //EMAIL_REQUIRED

        $otp_code = Helper::generate_otp();
        $otp = $auth_user->otps()->create([
            'code' => $otp_code,
            'expires_at' => now()->addMinutes(15),
            'trans_id' => $transaction->id,
            'use' => 'transaction',
        ]);
        //EMAIL_REQUIRED

        Mail::to(auth()->user())->send(new OTPMail($otp, auth()->user()));
        $auth_user->notify(new WireTransferNotification($transaction->notify));

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Transaction Initiated',
        ], 200);

    }
    public function wire_history()
    {
        return response()->json([
            'status' => true,
            'message' => 'Exchange money history updated ',
            'data' => auth()->user()->transactions()->where('type', 'wire_transfer')->take(8)->get(),
        ], 200);

    }
}
