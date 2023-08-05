<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TransactionMail;
use App\Models\FixedDeposit;
use App\Models\FixedDepositPlan;
use App\Models\User;
use App\Notifications\FixedDepositApprovalNotification;
use App\Notifications\FixedDepositDeclineNotification;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Validator;

class FDRController extends Controller
{
    //
    public function list_plans()
    {
        $plans = FixedDepositPlan::where('status', 'active')->get();
        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'plans' => $plans,
        ], 200);

    }
    public function plan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_id' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $plan = FixedDepositPlan::where('id', request('plan_id'))->first();

        if (!$plan) {
            return response()->json(['status' => false, 'message' => "Can not Find Plan"]);
        }

        return response()->json(['status' => true, 'message' => "Customer Fetch Successful", 'plan' => $plan]);

    }

    public function list_all_plans()
    {
        $plans = FixedDepositPlan::orderBy('created_at')->get();
        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'plans' => $plans,
        ], 200);

    }
    public function list_active_plans()
    {
        $plans = FixedDepositPlan::where('status', 'active')->orderBy('created_at')->get();
        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'plans' => $plans,
        ], 200);

    }
    public function list_not_active_plans()
    {
        $plans = FixedDepositPlan::where('status', 'not_active')->orderBy('created_at')->get();
        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'plans' => $plans,
        ], 200);

    }
    public function plan_activate(Request $request)
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

        $plan = FixedDepositPlan::where('id', request('id'))->first();
        if (!$plan) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to approve',
            ], 200);

        }
        if ($plan->status == 'active') {
            return response()->json([
                'status' => false,
                'message' => 'Plan Already Active',
            ], 200);
        }

        $plan->status = 'active';

        $plan->save();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
        ], 200);

    }
    public function plan_deactivate(Request $request)
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

        $plan = FixedDepositPlan::where('id', request('id'))->first();
        if (!$plan) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to approve',
            ], 200);

        }
        if ($plan->status == 'not_active') {
            return response()->json([
                'status' => false,
                'message' => 'Plan Not Active',
            ], 200);
        }

        $plan->status = 'not_active';

        $plan->save();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
        ], 200);

    }

    public function create_fdr(Request $request)
    {
        $plan = FixedDepositPlan::where('id', request('plan'))->first();
        $min_amount = ($plan) ? $plan->minimum_amount : 10;
        $max_amount = ($plan) ? $plan->maximum_amount : 10000;

        $v = Validator::make($request->all(), [
            'amount' => "required||numeric:min:$min_amount|max:$max_amount",
            'description' => 'required',
            'plan' => 'required',
            'currency' => 'required',
            'attachment' => 'nullable||mimes:jpeg,png,jpg,doc,pdf,docx,zip',
            'user' => 'required',
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

        DB::beginTransaction();

        $trans_ref = Helper::generate_trans_ref($user->id);
        $debit = $user->transactions()->create([
            'currency' => $request['currency'],
            'amount' => $request['amount'],
            'fee' => 0,
            'process' => 'credit',
            'method' => 'online',
            'type' => 'fixed_deposit',
            'status' => 'approved',
            'transaction_ref' => $trans_ref,
            'description' => $request['description'],
        ]);
        $user->account_details->add_balance($request['amount'], $request['currency']);

        $trans_ref = Helper::generate_trans_ref($user->id);

        $fixeddeposit = new FixedDeposit();
        $fixeddeposit->ref = $trans_ref;
        $fixeddeposit->fdr_plan_id = $request->plan;
        $fixeddeposit->user_id = $user->id;
        $fixeddeposit->currency = $request->currency;
        $fixeddeposit->deposit_amount = $request->amount;
        $fixeddeposit->status = 'approved';
        $fixeddeposit->return_amount = $request->deposit_amount + (($plan->interest_rate / 100) * $request->deposit_amount);
        $fixeddeposit->mature_date = date("Y-m-d", strtotime('+ ' . $plan->duration . ' ' . $plan->duration_type));
        $fixeddeposit->remarks = $request->remarks;
        $fixeddeposit->created_user_id = $user->id;
        $fixeddeposit->transaction_id = $debit->id;

        $fixeddeposit->save();

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => "Fixed Deposit Created Successfully",
        ], 200);

    }

    public function create_fd_plan(Request $request)
    {
        $v = Validator::make($request->all(), [
            'description' => 'required',
            'name' => 'required',
            'minimum' => 'required',
            'rate' => 'required',
            'duration' => 'required',
            'durationType' => 'required',
            'status' => 'required',
            'maximum' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        DB::beginTransaction();

        FixedDepositPlan::create([
            'name' => request('name'),
            'minimum_amount' => request('minimum'),
            'maximum_amount' => request('maximum'),
            'interest_rate' => request('rate'),
            'duration' => request('duration'),
            'duration_type' => request('durationType'),
            'description' => request('description'),
            'status' => request('status'),
        ]);

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => "Fixed Deposit Created Successfully",
        ], 200);

    }

    public function update_fd_plan(Request $request)
    {
        $v = Validator::make($request->all(), [
            'plan_id' => 'required',
            'description' => 'required',
            'name' => 'required',
            'minimum' => 'required',
            'rate' => 'required',
            'duration' => 'required',
            'durationType' => 'required',
            'status' => 'required',
            'maximum' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $plan = FixedDepositPlan::where('id', request('plan_id'))->first();

        if (!$plan) {
            return response()->json(['status' => false, 'message' => "Can not Find Plan"]);
        }

        DB::beginTransaction();

        $plan->name = request('name');
        $plan->minimum_amount = request('minimum');
        $plan->maximum_amount = request('maximum');
        $plan->interest_rate = request('rate');
        $plan->duration = request('duration');
        $plan->duration_type = request('durationType');
        $plan->description = request('description');
        $plan->status = request('status');
        $plan->save();

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => "Fixed Deposit Created Successfully",
        ], 200);

    }

    public function fixed_deposit_approve(Request $request)
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

        $payment_request = FixedDeposit::where('id', request('id'))->first();
        if (!$payment_request) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to approve',
            ], 200);

        }
        if ($payment_request->status == 'approved') {
            return response()->json([
                'status' => false,
                'message' => 'Deposit Already Approved',
            ], 200);
        }

        $user = User::where('id', $payment_request->user_id)->first();

        $trans_ref = Helper::generate_trans_ref($user->id);

        $payment_request->status = 'approved';

        $payment_request->save();

        $transaction = $user->transactions()->create([
            'currency' => $payment_request->currency,
            'amount' => $payment_request->deposit_amount,
            'fee' => 0.00,
            'process' => 'credit',
            'method' => 'manual',
            'type' => 'fixed_deposit',
            'status' => 'approved',
            'transaction_ref' => $trans_ref,
            'description' => $payment_request->description,
            'notify' => "Admin approved your deposit request",
        ]);
        $user->account_details->add_balance($payment_request->deposit_amount, $payment_request->currency);

        Mail::to($user)->send(new TransactionMail($transaction, $user));

        Mail::send('emails.status', ['messages' => "Your Fixed Deposit Request of  " . $transaction->currency . " " . $transaction->amount . " to with reference no. " . $transaction->transaction_ref . " was approved  ", 'firstName' => $user->name, 'subject' => "Fixed Deposit Approved"], function ($message) use ($request, $user) {
            $message->to($user->email);
            $message->subject("Fixed Deposit Request Approved");
        });

        $user->notify(new FixedDepositApprovalNotification("Your Fixed Deposit Request  with reference no. " . $transaction->transaction_ref . " is completed successfully "));

        return response()->json([
            'status' => true,
            'message' => 'Upload',
        ], 200);

    }
    public function fixed_deposit_reject(Request $request)
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

        $payment_request = FixedDeposit::where('id', request('id'))->first();
        if (!$payment_request) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to approve',
            ], 200);

        }
        if ($payment_request->status == 'pending') {

            $payment_request->status = 'declined';
            $payment_request->save();

            return response()->json([
                'status' => true,
                'message' => 'Deposit Rejected Successfully',
            ], 200);
        }

        if ($payment_request->status == 'approved') {

            $user = User::where('id', $payment_request->user_id)->first();

            $trans_ref = Helper::generate_trans_ref($user->id);

            $payment_request->status = 'declined';

            $payment_request->save();

            $transaction = $user->transactions()->create([
                'currency' => $payment_request->currency,
                'amount' => $payment_request->deposit_amount,
                'fee' => 0.00,
                'process' => 'debit',
                'method' => 'manual',
                'type' => 'fixed_deposit',
                'status' => 'declined',
                'transaction_ref' => $trans_ref,
                'description' => $payment_request->description,
                'notify' => "Admin reject your deposit request",
            ]);
            $user->account_details->sub_balance($payment_request->deposit_amount, $payment_request->currency);

            // Mail::to($user)->send(new TransactionMail($transaction, $user));

            Mail::send('emails.status', ['messages' => "Your Fixed Deposit Request of  " . $transaction->currency . " " . $transaction->amount . " to with reference no. " . $transaction->transaction_ref . " was rejected  ", 'firstName' => $user->name, 'subject' => "Fixed Deposit Request declined"], function ($message) use ($request, $user) {
                $message->to($user->email);
                $message->subject("Fixed Deposit Request Declined");
            });

            $user->notify(new FixedDepositDeclineNotification("Your Fixed Deposit Request  with reference no. " . $transaction->transaction_ref . " was rejected "));

            return response()->json([
                'status' => true,
                'message' => 'Upload',
            ], 200);
        }

    }
    public function list_fixed_deposit(Request $request)
    {
        $fixed_deposits = FixedDeposit::orderBy('created_at')->with('plan')
            ->join('users', 'fixed_deposits.user_id', '=', 'users.id')
            ->select('users.email', 'users.name', 'fixed_deposits.*')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'fixed_deposits' => $fixed_deposits,
        ], 200);

    }
    public function list_fixed_deposit_approve(Request $request)
    {
        $fixed_deposits = FixedDeposit::orderBy('created_at')->with('plan')->where('fixed_deposits.status', 'approved')
            ->join('users', 'fixed_deposits.user_id', '=', 'users.id')
            ->select('users.email', 'users.name', 'fixed_deposits.*')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'fixed_deposits' => $fixed_deposits,
        ], 200);

    }
    public function list_fixed_deposit_pending(Request $request)
    {
        $fixed_deposits = FixedDeposit::orderBy('created_at')->with('plan')->where('fixed_deposits.status', 'pending')
            ->join('users', 'fixed_deposits.user_id', '=', 'users.id')
            ->select('users.email', 'users.name', 'fixed_deposits.*')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'fixed_deposits' => $fixed_deposits,
        ], 200);

    }
    public function list_fixed_deposit_declined(Request $request)
    {
        $fixed_deposits = FixedDeposit::orderBy('created_at')->with('plan')->where('fixed_deposits.status', 'declined')
            ->join('users', 'fixed_deposits.user_id', '=', 'users.id')
            ->select('users.email', 'users.name', 'fixed_deposits.*')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'fixed_deposits' => $fixed_deposits,
        ], 200);

    }
}
