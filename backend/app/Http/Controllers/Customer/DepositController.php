<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Services\Helper;
use Illuminate\Http\Request;
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
        //EMAIL_REQUIRED
        return response()->json(['status' => true, 'message' => "Deposit Requested successfully"]);
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
