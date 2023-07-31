<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{

    public function list_transaction()
    {

        $transactions = Transaction::orderBy("transactions.created_at", "desc")
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select('transactions.*', 'users.name', 'users.email')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'transactions' => $transactions,
        ], 200);

    }
    public function list_transaction_approved()
    {

        $transactions = Transaction::orderBy("transactions.created_at", "desc")->where('transactions.status', 'approved')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select('transactions.*', 'users.name', 'users.email')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'transactions' => $transactions,
        ], 200);

    }
    public function list_transaction_pending()
    {

        $transactions = Transaction::orderBy("transactions.created_at", "desc")->where('transactions.status', 'pending')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select('transactions.*', 'users.name', 'users.email')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'transactions' => $transactions,
        ], 200);

    }
    public function list_transaction_declined()
    {

        $transactions = Transaction::orderBy("transactions.created_at", "desc")->whereIn('transactions.status', ['declined', 'canceled'])
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select('transactions.*', 'users.name', 'users.email')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'transactions' => $transactions,
        ], 200);

    }

    public function single_withdraw_request(Request $request)
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

        $withdraw_requests = WithdrawRequest::select('withdraw_requests.*')->where('id', request('id'))
            ->with('user')
            ->with('method')
            ->with('method.currency')
            ->orderBy("withdraw_requests.id", "desc");

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'withdraw_requests' => $withdraw_requests,
        ], 200);

    }
}
