<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\FixedDeposit;
use App\Models\FixedDepositPlan;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class FixedDepositController extends Controller
{
    public function list_deposit_plans()
    {
        $plans = FixedDepositPlan::where('status', 'active')->get();
        return response()->json([
            'status' => true,
            'message' => "Deposit Plan List Updated Successfully",
            'plans' => $plans,
        ], 200);

    }

    public function my_fixed_deposit()
    {
        return response()->json([
            'status' => true,
            'message' => "Deposit Plan List Updated Successfully",
            'data' => auth()->user()->fixed_deposits,
        ], 200);

    }

    public function send_deposit_request(Request $request)
    {
        $plan = FixedDepositPlan::where('id', request('plan'))->first();
        $min_amount = ($plan) ? $plan->minimum_amount : 10;
        $max_amount = ($plan) ? $plan->maximum_amount : 10000;
        $auth_user = auth()->user();

        $v = Validator::make($request->all(), [
            'amount' => "required||numeric:min:$min_amount|max:$max_amount",
            'description' => 'required',
            'plan' => 'required',
            'currency' => 'required',
            'attachment' => 'nullable||mimes:jpeg,png,jpg,doc,pdf,docx,zip',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $attachment = "";
        if ($request->hasfile('attachment')) {
            $file = $request->file('attachment');
            $attachment = time() . $file->getClientOriginalName();
            $file->move(public_path() . "/uploads/fixed_deposits/", $attachment);
        }

        DB::beginTransaction();

        $trans_ref = Helper::generate_trans_ref(auth()->user()->id);
        // $debit = auth()->user()->transactions()->create([
        //     'currency' => $request['currency'],
        //     'amount' => $request['amount'],
        //     'fee' => 0,
        //     'process' => 'debit',
        //     'method' => 'online',
        //     'type' => 'fixed_deposit',
        //     'status' => 'pending',
        //     'transaction_ref' => $trans_ref,
        //     'description' => $request['description'],
        // ]);
        // auth()->user()->account_details->sub_balance( $request['amount'],$request['currency']);

        $trans_ref = Helper::generate_trans_ref(auth()->user()->id);

        $fixeddeposit = new FixedDeposit();
        $fixeddeposit->ref = $trans_ref;
        $fixeddeposit->fdr_plan_id = $request->plan;
        $fixeddeposit->user_id = auth()->id();
        $fixeddeposit->currency = $request->currency;
        $fixeddeposit->deposit_amount = $request->amount;
        $fixeddeposit->return_amount = $request->deposit_amount + (($plan->interest_rate / 100) * $request->deposit_amount);
        $fixeddeposit->mature_date = date("Y-m-d", strtotime('+ ' . $plan->duration . ' ' . $plan->duration_type));
        $fixeddeposit->attachment = $attachment;
        $fixeddeposit->remarks = $request->remarks;
        $fixeddeposit->created_user_id = auth()->user()->id;

        $fixeddeposit->save();

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => "Fixed Deposit Sent Successfully",
        ], 200);

    }
}
