<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use App\Models\Transaction;
use App\Models\User;
use App\Services\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class OtpController extends Controller
{
    public function get_otp(Request $request)
    {
        $auth_user = auth()->user();
        $otp = OtpCode::where('user_id', auth()->user()->id)->where('status', 'active')->orderBy('created_at', 'desc')->first();

        if (!$otp) {
            return response()->json([
                'status' => false,
                'message' => 'You don\'t have any Active OTP',
            ], 400);
        }
        $transaction = Transaction::where('id', $otp->trans_id)->first();

        if (!Carbon::create($otp->expires_at)->greaterThan(now())) {
            $otp->status = 'expired';
            $otp->save();
            $transaction->status = 'canceled';
            $transaction->notify = 'You Transaction was decline due to expired otp';
            $transaction->save();
            return response()->json([
                'status' => false,
                'message' => 'Your OTP Has Expired',
            ], 400);
        }

        $timediff = Carbon::create($otp->expires_at)->greaterThan(now());

        return response()->json([
            'status' => true,
            'message' => 'Checking OTP',
            "transaction" => $transaction,
            "timediff" => $timediff,
            "otp" => $otp->code,
        ], 200);

    }

    public function verify_otp(Request $request)
    {
        $auth_user = auth()->user();
        $v = Validator::make($request->all(), [
            'code' => 'required|exists:otp_codes',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $otp = OtpCode::where('code', request('code'))->where('status', 'active')->first();

        if (!$otp) {
            return response()->json([
                'status' => false,
                'message' => 'Your OTP Has Expired',
            ], 400);
        }

        $transaction = Transaction::where('id', $otp->trans_id)->where('status', 'awaiting_otp')->first();

        if (!$transaction) {
            return response()->json([
                'status' => false,
                'message' => 'Your Transaction Has Expired',
            ], 400);
        }

        if ($transaction->type == "send_money") {
            DB::beginTransaction();
            $user = User::where('id', $transaction->receiver_id)->first();
            $trans_ref = Helper::generate_trans_ref($user->id);
            $user->transactions()->create([
                'currency' => $transaction->currency,
                'amount' => $transaction->amount,
                'fee' => $transaction->fee,
                'process' => 'credit',
                'method' => 'online',
                'type' => 'send_money',
                'status' => 'approved',
                'transaction_ref' => $trans_ref,
                'description' => "",
                'notify' => "You are received " . $transaction->currency . " " . $transaction->amount . " from " . $auth_user->email,
                'sender_id' => $auth_user->id,
            ]);
            $user->account_details->add_balance($transaction->amount, $transaction->currency);
            //EMAIL_REQUIRED to receive money
            $otp->status = 'used';
            $otp->save();

            $transaction->status = 'approved';
            $transaction->notify = "You are Sent " . $transaction->currency . " " . $transaction->amount . " to " . $user->email;
            $transaction->save();

            $auth_user->account_details->sub_balance($transaction->amount, $transaction->currency);
            //EMAIL_REQUIRED to receive money

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Money Sent successfully',
            ], 200);

        }

        if ($transaction->type == "exchange") {
            DB::beginTransaction();

            $trans_ref = Helper::generate_trans_ref($auth_user->id);
            $auth_user->transactions()->create([
                'currency' => $transaction->x_currency,
                'amount' => $transaction->x_amount,
                'fee' => $transaction->fee,
                'process' => 'credit',
                'method' => 'online',
                'type' => 'exchange',
                'status' => 'approved',
                'transaction_ref' => $trans_ref,
                'description' => "",
                'notify' => "You are converted " . $transaction->currency . " to " . $transaction->x_currency,
            ]);
            $auth_user->account_details->add_balance($transaction->x_amount, $transaction->x_currency);
            //EMAIL_REQUIRED to receive money
            $otp->status = 'used';
            $otp->save();

            $transaction->status = 'approved';
            $transaction->notify = "You are converted " . $transaction->currency . " " . $transaction->x_currency;
            $transaction->save();

            $auth_user->account_details->sub_balance($transaction->amount, $transaction->currency);
            //EMAIL_REQUIRED to receive money

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Exchange Completed  Sent successfully',
            ], 200);

        }

        if ($transaction->type == "wire_transfer") {
            DB::beginTransaction();

            $otp->status = 'used';
            $otp->save();

            $transaction->status = 'approved';
            $transaction->notify = "You sent  money via wire tranfer" . $transaction->currency;
            $transaction->save();

            $auth_user->account_details->sub_balance($transaction->amount, $transaction->currency);
            //EMAIL_REQUIRED to Sent money

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Your Transfer Request send sucessfully. You will notified after reviewing by authority.',
            ], 200);

        }

    }
}
