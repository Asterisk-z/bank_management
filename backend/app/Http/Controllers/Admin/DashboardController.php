<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DepositRequest;
use App\Models\FixedDeposit;
use App\Models\Loan;
use App\Models\SupportTicket;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WithdrawRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {

        $user = auth()->user();

        $active_users = User::where('status', 'active')->count();
        $pending_kyc = User::where('kyc_status', 'no')->count();
        $pending_ticket = SupportTicket::where('status', 'pending')->count();
        $deposit_request = DepositRequest::where('status', 'pending')->count();
        $pending_withdraw = WithdrawRequest::where('status', 'pending')->count();
        $pending_loan = Loan::where('status', 'pending')->count();
        $total_fixed = FixedDeposit::where('status', 'pending')->count();
        $wire_amount = Transaction::where('type', 'wire_transfer')->where('status', 'approved')->count();
        $deposit_amount = DepositRequest::where('status', 'approved')->sum('amount');
        $withdraw_amount = WithdrawRequest::where('status', 'approved')->sum('amount');
        $loan_amount = Loan::where('status', 'approved')->sum('applied_amount');
        $exchange_amount = Transaction::where('type', 'exchange')->where('status', 'approved')->sum('amount');

        return response()->json(['status' => true, "data" => [
            "active_users" => $active_users,
            "pending_kyc" => $pending_kyc,
            "pending_ticket" => $pending_ticket,
            "deposit_request" => $deposit_request,
            "pending_withdraw" => $pending_withdraw,
            "pending_loan" => $pending_loan,
            "total_fixed" => $total_fixed,
            "wire_amount" => $wire_amount,
            "deposit_amount" => $deposit_amount,
            "withdraw_amount" => $withdraw_amount,
            "loan_amount" => $loan_amount,
            "exchange_amount" => $exchange_amount,
        ]], 200);
    }

    public function notification(Request $request)
    {

        $user = auth()->user();

        $notifications = DB::table('notifications')->join('users', 'notifications.notifiable_id', 'users.id')->orderBy('created_at')->select('notifications.*', 'users.name', 'users.email')->take(5)->get();

        return response()->json(['status' => true, "data" => [
            "notifications" => $notifications,
        ]], 200);
    }
    public function transaction(Request $request)
    {

        $user = auth()->user();

        $transactions = Transaction::orderBy('created_at')->take(5)->get();

        return response()->json(['status' => true, "data" => [
            "transactions" => $transactions,
        ]], 200);
    }

}
