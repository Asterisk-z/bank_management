<?php

use App\Http\Controllers\Admin\BankController as AdminBankController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DepositController as AdminDepositController;
use App\Http\Controllers\Admin\FDRController;
use App\Http\Controllers\Admin\GiftcardController;
use App\Http\Controllers\Admin\LoanController as AdminLoanController;
use App\Http\Controllers\Admin\LoanProductController;
use App\Http\Controllers\Admin\PaymentRequestController as AdminPaymentRequestController;
use App\Http\Controllers\Admin\SupportTicketController as AdminSupportTicketController;
use App\Http\Controllers\Admin\TransactionsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WireTransferController as AdminWireTransferController;
use App\Http\Controllers\Admin\WithdrawController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\Custoer\NotificationController;
use App\Http\Controllers\Customer\AccountController;
use App\Http\Controllers\Customer\CurrencyController as CustomerCurrencyController;
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
use App\Http\Controllers\Customer\WithdrawalController;
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

        Route::post('login_otp', [AuthController::class, 'login_otp']);

        Route::post('refresh', [AuthController::class, 'refresh']);

        Route::post('forgot_password', [AuthController::class, 'forgot_password']);

        Route::post('check_token', [AuthController::class, 'check_token']);

        Route::post('password_reset', [AuthController::class, 'password_reset']);

        Route::middleware('auth:api')->group(function () {

            Route::get('user', [AuthController::class, 'user']);
            Route::post('logout', [AuthController::class, 'logout']);

        });

    });

    Route::prefix('admin')->namespace('Admin')->middleware(['auth:api', 'admin'])->group(function () {
        Route::post('update_user', [UserController::class, 'update_user'])->name('update_user');
        Route::post('create_user', [UserController::class, 'create_user'])->name('create_user');
        Route::post('all_user', [UserController::class, 'all_user'])->name('all_user');
        Route::post('user', [UserController::class, 'single_user'])->name('single_user');
        Route::post('fetch_users', [UserController::class, 'fetch_users'])->name('fetch_users');
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
        Route::post('toggle_card', [UserController::class, 'toggle_card'])->name('toggle_card');
        Route::post('toggle_action', [UserController::class, 'toggle_action'])->name('toggle_action');
        Route::post('update_card_limit', [UserController::class, 'update_card_limit'])->name('update_card_limit');

        Route::post('create_ticket', [AdminSupportTicketController::class, 'create_ticket'])->name('create_ticket');
        Route::post('update_ticket', [AdminSupportTicketController::class, 'update_ticket'])->name('update_ticket');
        Route::post('list_tickets', [AdminSupportTicketController::class, 'list_tickets'])->name('list_tickets');
        Route::post('single_chat_ticket_detail', [AdminSupportTicketController::class, 'single_chat_ticket_detail'])->name('single_chat_ticket_detail');
        Route::post('list_tickets_active', [AdminSupportTicketController::class, 'list_tickets_active'])->name('list_tickets_active');
        Route::post('list_tickets_pending', [AdminSupportTicketController::class, 'list_tickets_pending'])->name('list_tickets_pending');
        Route::post('list_tickets_closed', [AdminSupportTicketController::class, 'list_tickets_closed'])->name('list_tickets_closed');
        Route::post('single_chat_ticket', [AdminSupportTicketController::class, 'single_chat_ticket'])->name('single_chat_ticket');
        Route::post('single_ticket', [AdminSupportTicketController::class, 'single_ticket'])->name('single_ticket');
        Route::post('send_message', [AdminSupportTicketController::class, 'send_message'])->name('send_message');
        Route::post('get_message', [AdminSupportTicketController::class, 'get_message'])->name('get_message');
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

        Route::post('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('dashboard_notification', [AdminDashboardController::class, 'notification'])->name('dashboardn');
        Route::post('dashboard_transaction', [AdminDashboardController::class, 'transaction'])->name('dashboardt');

        Route::post('list_withdraw_request', [WithdrawController::class, 'list_withdraw_request'])->name('list_withdraw_request');
        Route::post('create_withdraw', [WithdrawController::class, 'create_withdraw'])->name('create_withdraw');
        Route::post('approve_withdraw_request', [WithdrawController::class, 'approve_withdraw_request'])->name('approve_withdraw_request');
        Route::post('reject_withdraw_request', [WithdrawController::class, 'reject_withdraw_request'])->name('reject_withdraw_request');

        Route::post('list_withdraw_request_transaction', [WithdrawController::class, 'list_withdraw_request_transaction'])->name('list_withdraw_request_transaction');
        Route::post('list_withdraw_request_transaction_approved', [WithdrawController::class, 'list_withdraw_request_transaction_approved'])->name('list_withdraw_request_transaction_approved');
        Route::post('list_withdraw_request_transaction_pending', [WithdrawController::class, 'list_withdraw_request_transaction_pending'])->name('list_withdraw_request_transaction_pending');
        Route::post('list_withdraw_request_transaction_declined', [WithdrawController::class, 'list_withdraw_request_transaction_declined'])->name('list_withdraw_request_transaction_declined');
        Route::post('list_withdraw_request_approved', [WithdrawController::class, 'list_withdraw_request_approved'])->name('list_withdraw_request_approved');
        Route::post('list_withdraw_request_pending', [WithdrawController::class, 'list_withdraw_request_pending'])->name('list_withdraw_request_pending');
        Route::post('list_withdraw_request_declined', [WithdrawController::class, 'list_withdraw_request_declined'])->name('list_withdraw_request_declined');

        Route::post('list_transaction', [TransactionsController::class, 'list_transaction'])->name('list_transaction');
        Route::post('list_transaction_approved', [TransactionsController::class, 'list_transaction_approved'])->name('list_transaction_approved');
        Route::post('list_transaction_pending', [TransactionsController::class, 'list_transaction_pending'])->name('list_transaction_pending');
        Route::post('list_transaction_declined', [TransactionsController::class, 'list_transaction_declined'])->name('list_transaction_declined');

        Route::post('list_plans', [FDRController::class, 'list_plans'])->name('list_plans');
        Route::post('plan', [FDRController::class, 'plan'])->name('plan');
        Route::post('list_all_plans', [FDRController::class, 'list_all_plans'])->name('list_all_plans');
        Route::post('list_active_plans', [FDRController::class, 'list_active_plans'])->name('list_active_plans');
        Route::post('list_not_active_plans', [FDRController::class, 'list_not_active_plans'])->name('list_not_active_plans');
        Route::post('plan_activate', [FDRController::class, 'plan_activate'])->name('plan_activate');
        Route::post('plan_deactivate', [FDRController::class, 'plan_deactivate'])->name('plan_deactivate');

        Route::post('create_fdr', [FDRController::class, 'create_fdr'])->name('create_fdr');
        Route::post('create_fd_plan', [FDRController::class, 'create_fd_plan'])->name('create_fd_plan');
        Route::post('update_fd_plan', [FDRController::class, 'update_fd_plan'])->name('update_fd_plan');
        Route::post('list_fixed_deposit', [FDRController::class, 'list_fixed_deposit'])->name('list_fixed_deposit');
        Route::post('list_fixed_deposit_approve', [FDRController::class, 'list_fixed_deposit_approve'])->name('list_fixed_deposit_approve');
        Route::post('list_fixed_deposit_pending', [FDRController::class, 'list_fixed_deposit_pending'])->name('list_fixed_deposit_pending');
        Route::post('list_fixed_deposit_declined', [FDRController::class, 'list_fixed_deposit_declined'])->name('list_fixed_deposit_declined');
        Route::post('fixed_deposit_approve', [FDRController::class, 'fixed_deposit_approve'])->name('fixed_deposit_approve');
        Route::post('fixed_deposit_reject', [FDRController::class, 'fixed_deposit_reject'])->name('fixed_deposit_reject');

        Route::post('create_gift_card', [GiftcardController::class, 'create_gift_card'])->name('create_gift_card');
        Route::post('list_gift_card', [GiftcardController::class, 'list_gift_card'])->name('list_gift_card');
        Route::post('list_used_gift_card', [GiftcardController::class, 'list_used_gift_card'])->name('list_used_gift_card');
        Route::post('list_active_gift_card', [GiftcardController::class, 'list_active_gift_card'])->name('list_active_gift_card');
        Route::post('list_canceled_gift_card', [GiftcardController::class, 'list_canceled_gift_card'])->name('list_canceled_gift_card');
        Route::post('activate_giftcard', [GiftcardController::class, 'activate_giftcard'])->name('activate_giftcard');
        Route::post('cancel_giftcard', [GiftcardController::class, 'cancel_giftcard'])->name('cancel_giftcard');

        Route::post('create_currency', [CurrencyController::class, 'create_currency'])->name('create_currency');
        Route::post('update_currency', [CurrencyController::class, 'update_currency'])->name('update_currency');
        Route::post('list_currency', [CurrencyController::class, 'list_currency'])->name('list_currency');
        Route::post('fetch_currencies', [CurrencyController::class, 'fetch_currencies'])->name('fetch_currencies');
        Route::post('list_active_currency', [CurrencyController::class, 'list_active_currency'])->name('list_active_currency');
        Route::post('list_not_active_currency', [CurrencyController::class, 'list_not_active_currency'])->name('list_not_active_currency');
        Route::post('activate_currency', [CurrencyController::class, 'activate_currency'])->name('activate_currency');
        Route::post('deactivate_currency', [CurrencyController::class, 'deactivate_currency'])->name('deactivate_currency');
        Route::post('make_base_currency', [CurrencyController::class, 'make_base_currency'])->name('make_base_currency');
        Route::post('single_currency', [CurrencyController::class, 'single_currency'])->name('single_currency');

        Route::post('create_bank', [AdminBankController::class, 'create_bank'])->name('create_bank');
        Route::post('update_bank', [AdminBankController::class, 'update_bank'])->name('update_bank');
        Route::post('get_bank', [AdminBankController::class, 'get_bank'])->name('get_bank');
        Route::post('list_banks', [AdminBankController::class, 'list_banks'])->name('list_banks');
        Route::post('bank_activate', [AdminBankController::class, 'bank_activate'])->name('bank_activate');
        Route::post('bank_deactivate', [AdminBankController::class, 'bank_deactivate'])->name('bank_deactivate');
        Route::post('list_active_bank', [AdminBankController::class, 'list_active_bank'])->name('list_active_bank');
        Route::post('list_not_active_bank', [AdminBankController::class, 'list_not_active_bank'])->name('list_not_active_bank');

        Route::post('create_loan_product', [LoanProductController::class, 'create_loan_product'])->name('create_loan_product');
        Route::post('update_loan_product', [LoanProductController::class, 'update_loan_product'])->name('update_loan_product');
        Route::post('all_loan_product', [LoanProductController::class, 'all_loan_product'])->name('all_loan_product');
        Route::post('get_loan_product', [LoanProductController::class, 'get_loan_product'])->name('get_loan_product');
        Route::post('all_active_loan_product', [LoanProductController::class, 'all_active_loan_product'])->name('all_active_loan_product');
        Route::post('all_not_active_loan_product', [LoanProductController::class, 'all_not_active_loan_product'])->name('all_not_active_loan_product');
        Route::post('activate_loan_product', [LoanProductController::class, 'activate_loan_product'])->name('activate_loan_product');
        Route::post('deactivate_loan_product', [LoanProductController::class, 'deactivate_loan_product'])->name('deactivate_loan_product');
        Route::post('fetch_products', [LoanProductController::class, 'fetch_products'])->name('fetch_products');

        Route::post('create_loan', [AdminLoanController::class, 'create_loan'])->name('create_loan');
        Route::post('update_loan', [AdminLoanController::class, 'update_loan'])->name('update_loan');
        Route::post('single_loan', [AdminLoanController::class, 'single_loan'])->name('single_loan');
        Route::post('single_editable_loan', [AdminLoanController::class, 'single_editable_loan'])->name('single_editable_loan');
        Route::post('list_loans', [AdminLoanController::class, 'list_loans'])->name('list_loans');
        Route::post('create_loan_payment', [AdminLoanController::class, 'create_loan_payment'])->name('create_loan_payment');
        Route::post('list_loan_payments', [AdminLoanController::class, 'list_loan_payments'])->name('list_loan_payments');
        Route::post('list_loans_payment_detail_for_payments', [AdminLoanController::class, 'list_loans_payment_detail_for_payments'])->name('list_loans_payment_detail_for_payments');
        Route::post('list_active_loans_for_payments', [AdminLoanController::class, 'list_active_loans_for_payments'])->name('list_active_loans_for_payments');
        Route::post('list_loans_payment_for_payments', [AdminLoanController::class, 'list_loans_payment_for_payments'])->name('list_loans_payment_for_payments');
        Route::post('list_active_loans', [AdminLoanController::class, 'list_active_loans'])->name('list_active_loans');
        Route::post('list_pending_loans', [AdminLoanController::class, 'list_pending_loans'])->name('list_pending_loans');
        Route::post('list_canceled_loans', [AdminLoanController::class, 'list_canceled_loans'])->name('list_canceled_loans');
        Route::post('accept_loan', [AdminLoanController::class, 'accept_loan'])->name('accept_loan');
        Route::post('decline_loan', [AdminLoanController::class, 'decline_loan'])->name('decline_loan');
        Route::post('calculate', [AdminLoanController::class, 'calculate'])->name('calculate');

    });

    Route::prefix('customer')->namespace('Customer')->middleware(['auth:api', 'customer'])->group(function () {
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
        Route::post('single_chat_ticket_detail', [SupportTicketController::class, 'single_chat_ticket_detail'])->name('single_chat_ticket_detail');
        Route::post('get_message', [SupportTicketController::class, 'get_message'])->name('get_message');
        Route::post('send_message', [SupportTicketController::class, 'send_message'])->name('send_message');

        Route::post('list_loan_products', [LoanController::class, 'list_loan_products'])->name('list_loan_products');
        Route::post('loan_request', [LoanController::class, 'loan_request'])->name('loan_request');
        Route::post('my_loans', [LoanController::class, 'my_loans'])->name('my_loans');

        Route::post('list_deposit_plans', [FixedDepositController::class, 'list_deposit_plans'])->name('list_deposit_plans');
        Route::post('send_deposit_request', [FixedDepositController::class, 'send_deposit_request'])->name('send_deposit_request');
        Route::post('my_fixed_deposit', [FixedDepositController::class, 'my_fixed_deposit'])->name('my_fixed_deposit');

        Route::post('upload_profile', [ProfileController::class, 'upload_profile'])->name('upload_profile');

        Route::post('update_password', [AccountController::class, 'update_password'])->name('update_password');
        Route::post('email_update', [AccountController::class, 'email_update'])->name('email_update');
        Route::post('toggle_card', [AccountController::class, 'toggle_card'])->name('toggle_card');

        Route::post('fetch_currency', [CustomerCurrencyController::class, 'fetch_currency'])->name('fetch_currency');

        Route::post('withdraw', [WithdrawalController::class, 'withdraw'])->name('withdraw');
        Route::post('withdraw_requests', [WithdrawalController::class, 'withdraw_requests'])->name('withdraw_requests');

    });

    Route::middleware(['auth:api'])->group(function () {
        Route::post('customer/notifications', [NotificationController::class, 'notifications'])->name('notifications');
        Route::post('customer/all_notifications', [NotificationController::class, 'all_notifications'])->name('all_notifications');
    });

});
