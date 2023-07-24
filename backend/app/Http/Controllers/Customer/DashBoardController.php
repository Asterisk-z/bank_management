<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    public function dashboard(Request $request)
    {
        $last_transaction = Transaction::where('user_id', auth()->user()->id)->where('status', 'approved')->orderBy('created_at', 'desc')->first();
        $account_details = auth()->user()->account_details;
        $recent_transaction = auth()->user()->transactions()->take(5)->get();
        $recent_notification = auth()->user()->notifications()->take(5)->get();
        return response()->json([
            'status' => true,
            'message' => "Dashboard Update Successfully",
            'data' => [
                'last_transaction' => $last_transaction,
                'account_details' => $account_details,
                'recent_transaction' => $recent_transaction,
                'recent_notification' => $recent_notification,
            ]
        ], 200);

    }
}
