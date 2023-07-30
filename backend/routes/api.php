<?php

use App\Http\Controllers\Admin\DepositController as AdminDepositController;
use App\Http\Controllers\Admin\PaymentRequestController as AdminPaymentRequestController;
use App\Http\Controllers\Admin\SupportTicketController as AdminSupportTicketController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WireTransferController as AdminWireTransferController;
use App\Http\Controllers\Admin\WithdrawController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\Custoer\NotificationController;
use App\Http\Controllers\Customer\DashBoardController;
use App\Http\Controllers\Customer\DepositController;
use App\Http\Controllers\Customer\ExchangeMoneyController;
use App\Http\Controllers\Customer\FixedDepositController;
use App\Http\Controllers\Customer\LoanController;
use App\Http\Controllers\Customer\OtpController;
use App\Http\Controllers\Customer\PaymentRequestController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\SendMoneyController;
use App\Http\Controllers\Customer\SupportTicketController;
use App\Http\Controllers\Customer\TransactionController;
use App\Http\Controllers\Customer\WireTransferController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {

        Route::post('register', [AuthController::class, 'register']);

        Route::post('login', [AuthController::class, 'login']);

        Route::post('refresh', [AuthController::class, 'refresh']);

        Route::post('forgot_password', [AuthController::class, 'forgot_password']);

        Route::post('check_token', [AuthController::class, 'check_token']);

        Route::post('password_reset', [AuthController::class, 'password_reset']);

        Route::middleware('auth:api')->group(function () {

            Route::get('user', [AuthController::class, 'user']);
            Route::post('logout', [AuthController::class, 'logout']);

        });

    });

    Route::prefix('admin')->namespace('Admin')->middleware('auth:api')->group(function () {
        Route::post('create_user', [UserController::class, 'create_user'])->name('create_user');
        Route::post('all_user', [UserController::class, 'all_user'])->name('all_user');
        Route::post('user', [UserController::class, 'single_user'])->name('single_user');
        Route::post('user_transactions', [UserController::class, 'user_transactions'])->name('user_transactions');
        Route::post('add_money', [UserController::class, 'add_money'])->name('add_money');
        Route::post('deduct_money', [UserController::class, 'deduct_money'])->name('deduct_money');
        Route::post('user_loans', [UserController::class, 'user_loans'])->name('user_loans');
        Route::post('user_fixed_deposit', [UserController::class, 'user_fixed_deposit'])->name('user_fixed_deposit');
        Route::post('user_tickets', [UserController::class, 'user_tickets'])->name('user_tickets');
        Route::post('user_send_email', [UserController::class, 'user_send_email'])->name('user_send_email');
        Route::post('toggle_currency', [UserController::class, 'toggle_currency'])->name('toggle_currency');
        Route::post('toggle_account', [UserController::class, 'toggle_account'])->name('toggle_account');
        Route::post('toggle_kyc', [UserController::class, 'toggle_kyc'])->name('toggle_kyc');
        Route::post('toggle_action', [UserController::class, 'toggle_action'])->name('toggle_action');

        Route::post('make_active', [AdminSupportTicketController::class, 'make_active'])->name('make_active');
        Route::post('close_ticket', [AdminSupportTicketController::class, 'close_ticket'])->name('close_ticket');

        Route::post('transfer_requests', [AdminPaymentRequestController::class, 'transfer_requests'])->name('transfer_requests');
        Route::post('transfer_requests_pending', [AdminPaymentRequestController::class, 'transfer_requests_pending'])->name('transfer_requests_pending');
        Route::post('transfer_requests_paid', [AdminPaymentRequestController::class, 'transfer_requests_paid'])->name('transfer_requests_paid');
        Route::post('transfer_requests_canceled', [AdminPaymentRequestController::class, 'transfer_requests_canceled'])->name('transfer_requests_canceled');
        Route::post('cancel_request', [AdminPaymentRequestController::class, 'cancel_request'])->name('cancel_request');

        Route::post('list_wire_transfer', [AdminWireTransferController::class, 'list_wire_transfer'])->name('list_wire_transfer');
        Route::post('list_pending_wire_transfer', [AdminWireTransferController::class, 'list_pending_wire_transfer'])->name('list_pending_wire_transfer');
        Route::post('list_approved_wire_transfer', [AdminWireTransferController::class, 'list_approved_wire_transfer'])->name('list_approved_wire_transfer');
        Route::post('list_rejected_wire_transfer', [AdminWireTransferController::class, 'list_rejected_wire_transfer'])->name('list_rejected_wire_transfer');
        Route::post('cancel_wire_transfer', [AdminWireTransferController::class, 'cancel_wire_transfer'])->name('cancel_wire_transfer');
        Route::post('approve_wire_transfer', [AdminWireTransferController::class, 'approve_wire_transfer'])->name('approve_wire_transfer');

        Route::post('create_deposit', [AdminDepositController::class, 'create_deposit'])->name('create_deposit');
        Route::post('list_user', [AdminDepositController::class, 'list_user'])->name('list_user');
        Route::post('list_deposit', [AdminDepositController::class, 'list_deposit'])->name('list_deposit');
        Route::post('list_deposit_transaction', [AdminDepositController::class, 'list_deposit_transaction'])->name('list_deposit_transaction');
        Route::post('list_deposit_transaction_approved', [AdminDepositController::class, 'list_deposit_transaction_approved'])->name('list_deposit_transaction_approved');
        Route::post('list_deposit_transaction_pending', [AdminDepositController::class, 'list_deposit_transaction_pending'])->name('list_deposit_transaction_pending');
        Route::post('list_deposit_transaction_declined', [AdminDepositController::class, 'list_deposit_transaction_declined'])->name('list_deposit_transaction_declined');
        Route::post('list_deposit_pending', [AdminDepositController::class, 'list_deposit_pending'])->name('list_deposit_pending');
        Route::post('list_deposit_approved', [AdminDepositController::class, 'list_deposit_approved'])->name('list_deposit_approved');
        Route::post('list_deposit_canceled', [AdminDepositController::class, 'list_deposit_canceled'])->name('list_deposit_canceled');
        Route::post('approved_deposit', [AdminDepositController::class, 'approved_deposit'])->name('approved_deposit');
        Route::post('cancel_deposit', [AdminDepositController::class, 'cancel_deposit'])->name('cancel_deposit');

        Route::post('list_withdraw_request', [WithdrawController::class, 'list_withdraw_request'])->name('list_withdraw_request');

    });

    Route::prefix('customer')->namespace('Customer')->middleware('auth:api')->group(function () {
        Route::post('dashboard', [DashBoardController::class, 'dashboard'])->name('dashboard');
        Route::post('deposit_via_payoneer', [DepositController::class, 'payoneer'])->name('deposit_via_payoneer');
        Route::post('deposit_via_check', [DepositController::class, 'check'])->name('deposit_via_check');
        Route::post('deposit_via_blockchain', [DepositController::class, 'blockchain'])->name('deposit_via_blockchain');
        Route::post('deposit_via_paypal', [DepositController::class, 'paypal'])->name('deposit_via_paypal');
        Route::post('use_gift_card', [DepositController::class, 'use_gift_card'])->name('use_gift_card');
        Route::post('check_gift_card', [DepositController::class, 'check_gift_card'])->name('check_gift_card');
        Route::post('deposit_requests', [DepositController::class, 'list_requests'])->name('deposit_requests');

        Route::post('send_money', [SendMoneyController::class, 'send_money'])->name('send_money');
        Route::post('send_money_history', [SendMoneyController::class, 'send_money_history'])->name('send_money_history');

        Route::post('exchange', [ExchangeMoneyController::class, 'exchange'])->name('exchange');
        Route::post('exchange_history', [ExchangeMoneyController::class, 'exchange_history'])->name('exchange_history');

        Route::post('wire_transfer', [WireTransferController::class, 'wire_transfer'])->name('wire_transfer');
        Route::post('wire_history', [WireTransferController::class, 'wire_history'])->name('wire_history');

        Route::post('get_otp', [OtpController::class, 'get_otp'])->name('get_otp');
        Route::post('verify_otp', [OtpController::class, 'verify_otp'])->name('verify_otp');

        Route::post('get_swift', [BankController::class, 'get_swift'])->name('get_swift');

        Route::post('request_payment', [PaymentRequestController::class, 'request_payment'])->name('request_payment');
        Route::post('all_request', [PaymentRequestController::class, 'all_request'])->name('all_request');
        Route::post('sent_request', [PaymentRequestController::class, 'sent_request'])->name('sent_request');
        Route::post('received_requests', [PaymentRequestController::class, 'received_requests'])->name('received_requests');
        Route::post('pay_request', [PaymentRequestController::class, 'pay_request'])->name('pay_request');

        Route::post('list_transactions', [TransactionController::class, 'index'])->name('list_transactions');

        Route::post('create_ticket', [SupportTicketController::class, 'create_ticket'])->name('create_ticket');
        Route::post('list_tickets', [SupportTicketController::class, 'list_tickets'])->name('list_tickets');
        Route::post('close_ticket', [SupportTicketController::class, 'close_ticket'])->name('close_ticket');
        Route::post('find_ticket', [SupportTicketController::class, 'find_ticket'])->name('find_ticket');

        Route::post('list_loan_products', [LoanController::class, 'list_loan_products'])->name('list_loan_products');
        Route::post('loan_request', [LoanController::class, 'loan_request'])->name('loan_request');
        Route::post('my_loans', [LoanController::class, 'my_loans'])->name('my_loans');

        Route::post('list_deposit_plans', [FixedDepositController::class, 'list_deposit_plans'])->name('list_deposit_plans');
        Route::post('send_deposit_request', [FixedDepositController::class, 'send_deposit_request'])->name('send_deposit_request');
        Route::post('my_fixed_deposit', [FixedDepositController::class, 'my_fixed_deposit'])->name('my_fixed_deposit');

        Route::post('upload_profile', [ProfileController::class, 'upload_profile'])->name('upload_profile');
        Route::post('notifications', [NotificationController::class, 'notifications'])->name('notifications');
        Route::post('all_notifications', [NotificationController::class, 'all_notifications'])->name('all_notifications');

    });

});
