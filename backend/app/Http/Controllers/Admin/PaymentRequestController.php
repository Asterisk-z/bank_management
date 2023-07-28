<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use Illuminate\Http\Request;

class PaymentRequestController extends Controller
{
    //
    public function transfer_requests(Request $request)
    {
        $payment_requests = PaymentRequest::all();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'payment_requests' => $payment_requests,
        ], 200);

    }

    public function transfer_requests_pending(Request $request)
    {
        $payment_requests = PaymentRequest::where('status', 'pending')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'payment_requests' => $payment_requests,
        ], 200);

    }

    public function transfer_requests_paid(Request $request)
    {
        $payment_requests = PaymentRequest::where('status', 'paid')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'payment_requests' => $payment_requests,
        ], 200);

    }

    public function transfer_requests_canceled(Request $request)
    {
        $payment_requests = PaymentRequest::where('status', 'canceled')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'payment_requests' => $payment_requests,
        ], 200);

    }

    public function cancel_request(Request $request)
    {
        $payment_requests = PaymentRequest::where('status', 'canceled')->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'payment_requests' => $payment_requests,
        ], 200);

    }
}
