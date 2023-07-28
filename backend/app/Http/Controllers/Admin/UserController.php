<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AccountBlockedMail;
use App\Mail\TransactionMail;
use App\Models\AccountInfomation;
use App\Models\FixedDeposit;
use App\Models\Loan;
use App\Models\SupportTicket;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\SendMoneyNotification;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Validator;

class UserController extends Controller
{
    public function create_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'branch_id' => 'required',
            // 'password' => 'required|min:6',
            'country_code' => 'required|min:2|max:6',
            'phone_number' => 'required|min:10',
            'profile_picture' => 'nullable|image',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $profile_picture = "";
        if ($request->hasfile('profile_picture')) {
            $file = $request->file('profile_picture');
            $profile_picture = time() . $file->getClientOriginalName();
            $file->move(public_path() . "/uploads/profile/", $profile_picture);
        }
        $password = Helper::generate_temp_password(10);
        $user = User::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'name' => $request->first_name . " " . $request->last_name,
            'country_code' => $request->country_code,
            'phone' => $request->phone_number,
            'password' => bcrypt($password),
            'temp_password' => $password,
            'email' => $request->email,
            'create_by_admin' => 'yes',
            // 'account_number' => $request->account_number,
            'branch_id' => $request->branch_id,
            'profile_picture' => $profile_picture,
        ]);

        $account_number = Helper::generate_account_number();
        $card_number = Helper::generate_card_number();
        $user->account_details()->create(['account_number' => $account_number, 'first_card_number' => $card_number]);

        // $user->notify((new AdminNewCustomerNotification)->delay(now()->addMinutes(2)));

        return response()->json(['status' => true, 'message' => "user created successfully", "user" => $user]);

    }

    public function all_user()
    {
        $users = User::where('user_type', 'customer')->get();
        return response()->json(['status' => true, 'message' => "Customer Fetch Successful", 'users' => $users]);
    }

    public function single_user(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $user = User::where('id', request('user_id'))->with('account_details')->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => "Can not Find User"]);
        }

        return response()->json(['status' => true, 'message' => "Customer Fetch Successful", 'user' => $user]);

    }

    public function user_transactions(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $user = User::where('id', request('user_id'))->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => "Can not Find User"]);
        }

        $transactions = Transaction::where('user_id', request('user_id'))->get();

        return response()->json(['status' => true, 'message' => "Customer Fetch Successful", 'transactions' => $transactions]);

    }

    public function user_loans(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $user = User::where('id', request('user_id'))->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => "Can not Find User"]);
        }

        $loans = Loan::where('borrower_id', request('user_id'))->get();

        return response()->json(['status' => true, 'message' => "Customer Fetch Successful", 'loans' => $loans]);

    }

    public function user_fixed_deposit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $user = User::where('id', request('user_id'))->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => "Can not Find User"]);
        }

        $fixed_deposits = FixedDeposit::where('user_id', request('user_id'))->get();

        return response()->json(['status' => true, 'message' => "Customer Fetch Successful", 'fixed_deposits' => $fixed_deposits]);

    }

    public function user_tickets(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $user = User::where('id', request('user_id'))->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => "Can not Find User"]);
        }

        $tickets = SupportTicket::where('user_id', request('user_id'))->get();

        return response()->json(['status' => true, 'message' => "Customer Fetch Successful", 'tickets' => $tickets]);

    }

    public function user_send_email(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|max:255',
            'subject' => 'required|max:255',
            'message' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $user = User::where('id', request('user_id'))->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => "Can not Find User"]);
        }

        $tickets = SupportTicket::where('user_id', request('user_id'))->get();

        return response()->json(['status' => true, 'message' => "Customer Fetch Successful"]);

    }

    public function add_money(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|max:255',
            'currency' => 'required|max:255',
            'amount' => 'required|max:255',
            'description' => 'required|max:255',
            // 'notify' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $user = User::where('id', request('user_id'))->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => "Can not Find User"]);
        }

        DB::beginTransaction();

        $trans_ref = Helper::generate_trans_ref($user->id);
        $receiverTransaction = $user->transactions()->create([
            'currency' => $request->currency,
            'amount' => $request->amount,
            'fee' => 0.00,
            'process' => 'credit',
            'method' => 'online',
            'type' => 'send_money',
            'status' => 'approved',
            'transaction_ref' => $trans_ref,
            'description' => $request->description,
            'notify' => "You are received " . $request->currency . " " . $request->amount . " from  Bank",
            'sender_id' => '1',
        ]);
        $user->account_details->add_balance($request->amount, $request->currency);

        Mail::to($user)->queue(new TransactionMail($receiverTransaction, $user));
        $user->notify(new SendMoneyNotification($receiverTransaction->notify));

        DB::commit();

        return response()->json(['status' => true, 'message' => "Money Added Successsfully"]);

    }

    public function deduct_money(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|max:255',
            'currency' => 'required|max:255',
            'amount' => 'required|max:255',
            'description' => 'required|max:255',
            // 'notify' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $user = User::where('id', request('user_id'))->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => "Can not Find User"]);
        }

        DB::beginTransaction();

        $trans_ref = Helper::generate_trans_ref($user->id);
        $receiverTransaction = $user->transactions()->create([
            'currency' => $request->currency,
            'amount' => $request->amount,
            'fee' => 0.00,
            'process' => 'debit',
            'method' => 'online',
            'type' => 'send_money',
            'status' => 'approved',
            'transaction_ref' => $trans_ref,
            'description' => $request->description,
            'notify' => "You were debited " . $request->currency . " " . $request->amount . " by  Bank",
            'sender_id' => '1',
        ]);
        $user->account_details->sub_balance($request->amount, $request->currency);

        Mail::to($user)->queue(new TransactionMail($receiverTransaction, $user));
        $user->notify(new SendMoneyNotification($receiverTransaction->notify));

        DB::commit();

        return response()->json(['status' => true, 'message' => "Money Deducted Successful"]);

    }

    public function user($user_id)
    {
        $users = User::where('user_type', 'customer')->get();
        return response()->json(['status' => true, 'message' => "Customer Fetch Successful", 'users' => $users]);
    }

    public function toggle_currency(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|max:255',
            'currency' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $user = User::where('id', request('user_id'))->with('account_details')->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => "Can not Find User"]);
        }

        $account = AccountInfomation::where('user_id', $user->id)->first();
        if (request('currency') == 'AUD') {
            $account->aud_status = $account->aud_status == "active" ? "not_active" : "active";
            $account->save();
        }

        if (request('currency') == 'USD') {
            $account->usd_status = $account->usd_status == "active" ? "not_active" : "active";
            $account->save();
        }
        if (request('currency') == 'EUR') {
            $account->eur_status = $account->eur_status == "active" ? "not_active" : "active";
            $account->save();
        }

        return response()->json(['status' => true, 'message' => "Customer Fetch Successful", "user" => $user]);

    }

    public function toggle_account(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $user = User::where('id', request('user_id'))->with('account_details')->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => "Can not Find User"]);
        }

        $account = AccountInfomation::where('user_id', $user->id)->first();

        if ($user->status == "active") {
            $user->status = 'not_active';
            $account->status = 'not_active';
            $account->can_withdraw = 'not_active';

            $user->save();
            $account->save();
            Mail::to($user)->send(new AccountBlockedMail($user));

        } else {
            $user->status = 'active';
            $account->status = 'active';
            $account->can_withdraw = 'active';

            $user->save();
            $account->save();

        }

        return response()->json(['status' => true, 'message' => "Customer Fetch Successful", "user" => $user]);

    }

    public function toggle_kyc(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|max:255',
            'currency' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $user = User::where('id', request('user_id'))->with('account_details')->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => "Can not Find User"]);
        }

        $account = AccountInfomation::where('user_id', $user->id)->first();
        if (request('currency') == 'AUD') {
            $account->aud_status = $account->aud_status == "active" ? "not_active" : "active";
            $account->save();
        }

        if (request('currency') == 'USD') {
            $account->usd_status = $account->usd_status == "active" ? "not_active" : "active";
            $account->save();
        }
        if (request('currency') == 'EUR') {
            $account->eur_status = $account->eur_status == "active" ? "not_active" : "active";
            $account->save();
        }

        return response()->json(['status' => true, 'message' => "Customer Fetch Successful", "user" => $user]);

    }

    public function toggle_action(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|max:255',
            'currency' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $user = User::where('id', request('user_id'))->with('account_details')->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => "Can not Find User"]);
        }

        $account = AccountInfomation::where('user_id', $user->id)->first();
        if (request('currency') == 'AUD') {
            $account->aud_status = $account->aud_status == "active" ? "not_active" : "active";
            $account->save();
        }

        if (request('currency') == 'USD') {
            $account->usd_status = $account->usd_status == "active" ? "not_active" : "active";
            $account->save();
        }
        if (request('currency') == 'EUR') {
            $account->eur_status = $account->eur_status == "active" ? "not_active" : "active";
            $account->save();
        }

        return response()->json(['status' => true, 'message' => "Customer Fetch Successful", "user" => $user]);

    }

}
