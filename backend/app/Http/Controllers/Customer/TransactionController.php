<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => "Transactions Found",
            'data' => auth()->user()->transactions,
        ], 200);

    }
}
