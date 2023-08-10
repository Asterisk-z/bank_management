<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\TransactionMail;
use App\Models\GiftCard;
use App\Models\PaymentMethod;
use App\Notifications\DepositMoneyNotification;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Validator;

class DepositController extends Controller
{
    public function payoneer(Request $request)
    {
        $v = Validator::make($request->all(), [
            'amount' => 'required',
            'currency' => 'required',
            'description' => 'required',
            'file' => 'required',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $payment_method = PaymentMethod::where('name', 'payoneer')->where('type', 'deposit')->where('process', 'manual')->first();

        if (!$payment_method) {
            return response()->json([
                'status' => false,
                'errors' => "Payment Method Not Available",
            ], 422);

        }

        $attachment = "";
        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $attachment = time() . $file->getClientOriginalName();
            $file->move(public_path() . "/uploads/deposit_proof/", $attachment);
        }
        $deposit_ref = Helper::generate_deposit_ref(auth()->user()->id);
        auth()->user()->deposit_requests()->create([
            'method' => 'payoneer',
            'amount' => $request['amount'],
            'currency' => $request['currency'],
            'description' => $request['description'],
            'proof' => $attachment,
            'deposit_ref' => $deposit_ref,
        ]);

        auth()->user()->notify(new DepositMoneyNotification("Your Deposit Request  of " . $request->currency . " " . $request->amount . " is pending "));

        //EMAIL_REQUIRED
        return response()->json(['status' => true, 'message' => "Deposit Requested successfully"]);
    }
    public function check(Request $request)
    {
        $v = Validator::make($request->all(), [
            'amount' => 'required',
            'currency' => 'required',
            'description' => 'required',
            'file' => 'required',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        // $payment_method = PaymentMethod::where('name', 'payoneer')->where('type', 'deposit')->where('process', 'manual')->first();

        // if (!$payment_method) {
        //     return response()->json([
        //         'status' => false,
        //         'errors' => "Payment Method Not Available",
        //     ], 422);

        // }

        $attachment = "";
        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $attachment = time() . $file->getClientOriginalName();
            $file->move(public_path() . "/uploads/deposit_proof/", $attachment);
        }
        $deposit_ref = Helper::generate_deposit_ref(auth()->user()->id);
        auth()->user()->deposit_requests()->create([
            'method' => 'check',
            'amount' => $request['amount'],
            'currency' => $request['currency'],
            'description' => $request['description'],
            'proof' => $attachment,
            'deposit_ref' => $deposit_ref,
        ]);
        //EMAIL_REQUIRED
        auth()->user()->notify(new DepositMoneyNotification("Your Deposit Request  of " . $request->currency . " " . $request->amount . " is pending "));
        return response()->json(['status' => true, 'message' => "Deposit Requested successfully"]);
    }

    public function blockchain(Request $request)
    {
        $v = Validator::make($request->all(), [
            'amount' => 'required',
            'btc_value' => 'required',
            'description' => '',
            'currency' => 'required',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $payment_method = PaymentMethod::where('name', 'BitCoin')->where('type', 'deposit')->where('process', 'automatic')->first();

        if (!$payment_method) {
            return response()->json([
                'status' => false,
                'errors' => "Payment Method Not Available",
            ], 422);

        }

        $charge = $payment_method->fixed_charge;
        $charge += ($payment_method->charge_in_percentage / 100) * $request->amount;

        $deposit_ref = Helper::generate_deposit_ref(auth()->user()->id);
        auth()->user()->deposit_requests()->create([
            'method' => 'blockchain',
            'amount' => $request['amount'],
            'currency' => $request['currency'],
            'description' => $request['description'],
            'deposit_ref' => $deposit_ref,
            'status' => 'approved',
        ]);

        //PAYMENTGATEWAY

        $trans_ref = Helper::generate_trans_ref(auth()->user()->id);

        $transaction = auth()->user()->transactions()->create([
            'currency' => $request['currency'],
            'amount' => $request['amount'],
            'fee' => $charge,
            'process' => 'credit',
            'method' => 'blockchain',
            'type' => 'deposit',
            'status' => 'approved',
            'transaction_ref' => $trans_ref,
            'description' => $request['description'],
            'btc_value' => $request['btc_value'],
            'deposit_ref' => $deposit_ref,
            'notify' => "You made a deposit  vie blockchain",
        ]);
        auth()->user()->account_details->add_balance($request['amount'], $request['currency']);
        // auth()->user()->notify(new BlockChainNotication);
        // Mail
        // Notification::send(auth()->user(), new BlockChainNotication);

        Mail::to(auth()->user())->send(new TransactionMail($transaction, auth()->user()));
        auth()->user()->notify(new DepositMoneyNotification("Your Deposit Request  of " . $request->currency . " " . $request->amount . " is successful "));

        //EMAIL_REQUIRED
        return response()->json(['status' => true, 'message' => "Deposit Requested successfully"]);
    }

    public function paypal(Request $request)
    {
        $v = Validator::make($request->all(), [
            'amount' => 'required',
            'description' => 'required',
            'currency' => 'required',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $payment_method = PaymentMethod::where('name', 'PayPal')->where('type', 'deposit')->where('process', 'automatic')->first();

        if (!$payment_method) {
            return response()->json([
                'status' => false,
                'errors' => "Payment Method Not Available",
            ], 422);

        }

        $charge = $payment_method->fixed_charge;
        $charge += ($payment_method->charge_in_percentage / 100) * $request->amount;

        $deposit_ref = Helper::generate_deposit_ref(auth()->user()->id);
        auth()->user()->deposit_requests()->create([
            'method' => 'paypal',
            'amount' => $request['amount'],
            'currency' => $request['currency'],
            'description' => $request['description'],
            'deposit_ref' => $deposit_ref,
            'status' => 'approved',
        ]);

        //PAYMENTGATEWAY

        $trans_ref = Helper::generate_trans_ref(auth()->user()->id);

        auth()->user()->transactions()->create([
            'currency' => $request['currency'],
            'amount' => $request['amount'],
            'fee' => $charge,
            'process' => 'credit',
            'method' => 'paypal',
            'type' => 'deposit',
            'status' => 'approved',
            'transaction_ref' => $trans_ref,
            'description' => $request['description'],
            'deposit_ref' => $deposit_ref,
        ]);
        auth()->user()->account_details->add_balance($request['amount'], $request['currency']);
        //EMAIL_REQUIRED

        auth()->user()->notify(new DepositMoneyNotification("Your Deposit Request  of " . $request->currency . " " . $request->amount . " is successful "));

        return response()->json(['status' => true, 'message' => "Deposit Requested successfully"]);
    }

    public function check_gift_card(Request $request)
    {

        $gift_card = GiftCard::where('code', request('code'))->where('status', 'active')->where('is_general', 'yes')->first();
        if ($gift_card) {
            return response()->json(['status' => true, 'message' => "FOund Active GiftCard", 'data' => $gift_card]);
        }
        return response()->json(['status' => false, 'message' => "No active Gift Card"]);

    }

    public function use_gift_card(Request $request)
    {

        $gift_card = GiftCard::where('code', request('code'))->where('status', 'active')->where('is_general', 'yes')->first();
        if ($gift_card) {

            DB::beginTransaction();
            $trans_ref = Helper::generate_trans_ref(auth()->user()->id);

            auth()->user()->transactions()->create([
                'currency' => $gift_card->currency,
                'amount' => $gift_card->amount,
                'process' => 'credit',
                'method' => 'gift_card',
                'type' => 'deposit',
                'status' => 'approved',
                'transaction_ref' => $trans_ref,
                'description' => "Gift Card",
                'gift_card_id' => $gift_card->id,
            ]);

            $gift_card->status = 'used';
            $gift_card->stopped_at = now();
            $gift_card->save();
            auth()->user()->account_details->add_balance($gift_card->amount, $gift_card->currency);
            //EMAIL_REQUIRED

            auth()->user()->notify(new DepositMoneyNotification("Your Deposit  of " . $request->currency . " " . $request->amount . " is successful "));

            DB::commit();

            return response()->json(['status' => true, 'message' => "All User Deposit Requests", 'data' => $gift_card]);
        }
        return response()->json(['status' => false, 'message' => "No active Gift Card"]);

    }

    public function list_requests()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => "UnAuthorized",
            ], 422);
        }
        return response()->json(['status' => true, 'message' => "All User Deposit Requests", 'data' => auth()->user()->deposit_requests]);
    }
}
