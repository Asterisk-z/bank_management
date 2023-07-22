<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\Customer\DepositController;
use App\Http\Controllers\Customer\ExchangeMoneyController;
use App\Http\Controllers\Customer\OtpController;
use App\Http\Controllers\Customer\PaymentRequestController;
use App\Http\Controllers\Customer\SendMoneyController;
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

        Route::get('refresh', [AuthController::class, 'refresh']);

        Route::middleware('auth:api')->group(function () {

            Route::get('user', [AuthController::class, 'user']);
            Route::post('logout', [AuthController::class, 'logout']);

        });

    });

    Route::prefix('admin')->namespace('Admin')->middleware('auth:api')->group(function () {
        Route::post('create_user', [UserController::class, 'create_user'])->name('create_user');
        Route::post('all_user', [UserController::class, 'all_user'])->name('all_user');
        Route::post('user/{user_id}', [UserController::class, 'single_user'])->name('single_user');
    });

    Route::prefix('customer')->namespace('Customer')->middleware('auth:api')->group(function () {
        Route::post('deposit_via_payoneer', [DepositController::class, 'payoneer'])->name('deposit_via_payoneer');
        Route::post('deposit_via_blockchain', [DepositController::class, 'blockchain'])->name('deposit_via_blockchain');
        Route::post('deposit_via_paypal', [DepositController::class, 'paypal'])->name('deposit_via_paypal');
        Route::post('use_gift_card', [DepositController::class, 'use_gift_card'])->name('use_gift_card');
        Route::post('check_gift_card', [DepositController::class, 'check_gift_card'])->name('check_gift_card');
        Route::post('deposit_requests', [DepositController::class, 'list_requests'])->name('deposit_requests');

        Route::post('send_money', [SendMoneyController::class, 'send_money'])->name('send_money');
        Route::post('exchange', [ExchangeMoneyController::class, 'exchange'])->name('exchange');
        Route::post('wire_transfer', [WireTransferController::class, 'wire_transfer'])->name('wire_transfer');

        Route::post('get_otp', [OtpController::class, 'get_otp'])->name('get_otp');
        Route::post('verify_otp', [OtpController::class, 'verify_otp'])->name('verify_otp');

        Route::post('get_swift', [BankController::class, 'get_swift'])->name('get_swift');

        Route::post('request_payment', [PaymentRequestController::class, 'request_payment'])->name('request_payment');
        Route::post('all_request', [PaymentRequestController::class, 'all_request'])->name('all_request');
        Route::post('sent_request', [PaymentRequestController::class, 'sent_request'])->name('sent_request');
        Route::post('received_requests', [PaymentRequestController::class, 'received_requests'])->name('received_requests');
        Route::post('pay_request', [PaymentRequestController::class, 'pay_request'])->name('pay_request');

        Route::post('list_transactions', [TransactionController::class, 'index'])->name('list_transactions');

    });

});
