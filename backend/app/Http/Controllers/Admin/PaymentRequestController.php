<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use Illuminate\Http\Request;
use Validator;

class PaymentRequestController extends Controller
{
    //
    public function transfer_requests(Request $request)
    {
        $payment_requests = PaymentRequest::Where('payment_requests.branch_id', 1)
            ->join('users', 'payment_requests.benefactor', '=', 'users.id')
            ->with('user')->select('users.email', 'users.name', 'payment_requests.*')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'payment_requests' => $payment_requests,
        ], 200);

    }

    public function transfer_requests_pending(Request $request)
    {

        $payment_requests = PaymentRequest::Where('payment_requests.branch_id', 1)
            ->where('payment_requests.status', 'pending')
            ->join('users', 'payment_requests.benefactor', '=', 'users.id')
            ->with('user')->select('users.email', 'users.name', 'payment_requests.*')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'payment_requests' => $payment_requests,
        ], 200);

    }

    public function transfer_requests_paid(Request $request)
    {
        $payment_requests = PaymentRequest::Where('payment_requests.branch_id', 1)
            ->where('payment_requests.status', 'paid')
            ->join('users', 'payment_requests.benefactor', '=', 'users.id')
            ->with('user')->select('users.email', 'users.name', 'payment_requests.*')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'payment_requests' => $payment_requests,
        ], 200);

    }

    public function transfer_requests_canceled(Request $request)
    {

        $payment_requests = PaymentRequest::Where('payment_requests.branch_id', 1)
            ->where('payment_requests.status', 'canceled')
            ->join('users', 'payment_requests.benefactor', '=', 'users.id')
            ->with('user')->select('users.email', 'users.name', 'payment_requests.*')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'payment_requests' => $payment_requests,
        ], 200);

    }

    public function cancel_request(Request $request)
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

        $payment_request = PaymentRequest::where('id', request('id'))->first();

        $payment_request->status = 'canceled';

        $payment_request->save();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
        ], 200);

    }
}
