<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\TransactionMail;
use App\Models\OtpCode;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\ExchangeMoneyNotification;
use App\Notifications\SendMoneyNotification;
use App\Notifications\WireTransferNotification;
use App\Services\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
            $transaction->notify = 'Your Transaction was decline due to expired otp';
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
            $receiverTransaction = $user->transactions()->create([
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

            Mail::to($user)->send(new TransactionMail($receiverTransaction, $user));
            $user->notify(new SendMoneyNotification($receiverTransaction->notify));

            $otp->status = 'used';
            $otp->save();

            $transaction->status = 'approved';
            $transaction->notify = "You sent " . $transaction->currency . " " . $transaction->amount . " to " . $user->email;
            $transaction->save();

            $auth_user->account_details->sub_balance($transaction->amount, $transaction->currency);
            //EMAIL_REQUIRED to receive money

            Mail::to($auth_user)->send(new TransactionMail($transaction, $auth_user));
            $auth_user->notify(new SendMoneyNotification($transaction->notify));

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Money Sent successfully',
            ], 200);

        }

        if ($transaction->type == "exchange") {
            DB::beginTransaction();

            $trans_ref = Helper::generate_trans_ref($auth_user->id);
            $new_transaction = $auth_user->transactions()->create([
                'currency' => $transaction->x_currency,
                'amount' => $transaction->x_amount,
                'fee' => $transaction->fee,
                'process' => 'credit',
                'method' => 'online',
                'type' => 'exchange',
                'status' => 'approved',
                'transaction_ref' => $trans_ref,
                'description' => "",
                'notify' => "You converted  " . $transaction->currency . " " . number_format($transaction->amount, 2) . "  to " . $transaction->x_currency . " " . number_format($transaction->x_amount, 2),
            ]);
            $auth_user->account_details->add_balance($transaction->x_amount, $transaction->x_currency);
            //EMAIL_REQUIRED to receive money
            $otp->status = 'used';
            $otp->save();

            $transaction->status = 'approved';
            $transaction->notify = "You converted " . $transaction->currency . " " . number_format($transaction->amount, 2) . "  to " . $transaction->x_currency . " " . number_format($transaction->x_amount, 2);
            $transaction->save();

            $auth_user->account_details->sub_balance($transaction->amount, $transaction->currency);

            Mail::to($auth_user)->send(new TransactionMail($new_transaction, $auth_user));

            $auth_user->notify(new ExchangeMoneyNotification($new_transaction->notify));

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

            $transaction->status = 'pending';
            $transaction->notify = "Your  Wire Transfer is pending Approval";
            $transaction->save();

            $auth_user->account_details->sub_balance($transaction->amount, $transaction->currency);
            //EMAIL_REQUIRED to Sent money
            Mail::to($auth_user)->send(new TransactionMail($transaction, $auth_user));
            $auth_user->notify(new WireTransferNotification($transaction->notify));

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Your Transfer Request has been sent. You will notified after reviewed by authority.',
            ], 200);

        }

    }
}
