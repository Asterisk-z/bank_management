<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\TransactionMail;
use App\Models\PaymentRequest;
use App\Models\User;
use App\Notifications\SendMoneyNotification;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Validator;

class PaymentRequestController extends Controller
{
    public function request_payment(Request $request)
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

        if (!$auth_user->done_kyc()) {
            return response()->json([
                'status' => false,
                'message' => 'Debit Restricted Due to incomplete KYC',
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
                'message' => 'You can not request from yourself, try the deposit tab',
            ], 400);
        }

        DB::beginTransaction();

        $pay_ref = Helper::generate_payment_ref(auth()->user()->id);
        $pay = auth()->user()->payment_requests()->create([
            'currency' => $request['currency'],
            'amount' => $request['amount'],
            'payment_ref' => $pay_ref,
            'description' => $request['description'],
            'benefactor' => $user->id,
        ]);

        //EMAIL_REQUIRED
        //EMAIL_REQUIRED

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Payment Has been sent ',
            "pau" => $pay,
        ], 200);

    }

    public function all_request()
    {
        $payment = PaymentRequest::Where('user_id', auth()->user()->id)->join('users', 'payment_requests.benefactor', '=', 'users.id')->with('user')->select('users.email', 'users.name', 'payment_requests.*')->get();
        return response()->json([
            'status' => true,
            'message' => "Request Found",
            'data' => $payment,
        ], 200);
    }

    public function sent_request()
    {
        $payment = PaymentRequest::Where('user_id', auth()->user()->id)->join('users', 'payment_requests.benefactor', '=', 'users.id')->with('user')->select('users.email', 'users.name', 'payment_requests.*')->get();
        return response()->json([
            'status' => true,
            'message' => "Request Found",
            'data' => $payment,
        ], 200);
    }

    public function received_requests()
    {
        // $payment = PaymentRequest::Where('benefactor', auth()->user()->id)->join('users', 'payment_requests.benefactor', '=', 'users.id')->with('user')->select('users.email', 'users.name', 'payment_requests.*')->get();
        return response()->json([
            'status' => true,
            'message' => "Request Found",
            'data' => auth()->user()->received_requests,
        ], 200);
    }

    public function pay_request(Request $request)
    {
        $auth_user = auth()->user();
        $v = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }
        $pay_request = PaymentRequest::where('id', request('id'))->where('benefactor', $auth_user->id)->first();

        if (!$pay_request) {
            return response()->json([
                'status' => false,
                'message' => 'Can not Pay request',
            ], 400);
        }

        //Check Balance
        $received = $auth_user->transactions()->where('process', 'credit')->whereIn('status', ['approved', 'pending'])->where('currency', $pay_request->currency)->sum('amount');
        $sent = $auth_user->transactions()->where('process', 'debit')->whereIn('status', ['approved', 'pending'])->where('currency', $pay_request->currency)->sum('amount');
        $balance_from_transaction_history = round(floatval($received) - floatval($sent), 2);
        $stored_balance = $auth_user->account_details->balance($pay_request->currency);
        if ($stored_balance != $balance_from_transaction_history) {
            return response()->json([
                'status' => false,
                'message' => 'Your balance and transaction balance does not match',
            ], 400);
        }

        if ($stored_balance < $pay_request->amount) {
            return response()->json([
                'status' => false,
                'message' => 'Insufficient Fund, Try making a deposit',
            ], 400);
        }
        // Find Recipient
        $user = User::where('id', $pay_request->user_id)->orWhere('account_number', $pay_request->user_id)->first();

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
            'currency' => $pay_request->currency,
            'amount' => $pay_request->amount,
            'fee' => '0',
            'process' => 'debit',
            'method' => 'online',
            'type' => 'send_money',
            'status' => 'approved',
            'transaction_ref' => $trans_ref,
            'description' => $pay_request->description,
            'notify' => "You Sent " . $pay_request->currency . " " . $pay_request->amount . " to " . $user->email,
            'receiver_id' => $user->id,
        ]);

        $trans_ref = Helper::generate_trans_ref($user->id);
        $receiverTransaction = $user->transactions()->create([
            'currency' => $pay_request->currency,
            'amount' => $pay_request->amount,
            'fee' => '0',
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

        $auth_user->account_details->sub_balance($transaction->amount, $transaction->currency);
//EMAIL_REQUIRED to receive money

        Mail::to($auth_user)->send(new TransactionMail($transaction, $auth_user));
        $auth_user->notify(new SendMoneyNotification($transaction->notify));

        $pay_request->status = "paid";
        $pay_request->save();
        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Money Sent Successfully processed ',
        ], 200);

    }
}
