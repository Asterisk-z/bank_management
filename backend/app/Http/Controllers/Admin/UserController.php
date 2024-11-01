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
use Carbon\Carbon;
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
            'country_code' => 'required|min:1|max:6',
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

        Mail::send('emails.userPassword', ['code' => $user->temp_password, 'firstName' => $user->name], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Royal Bank Onboarding');
        });

        // $user->notify((new AdminNewCustomerNotification)->delay(now()->addMinutes(2)));

        return response()->json(['status' => true, 'message' => "user created successfully", "user" => $user]);

    }

    public function update_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|max:255',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            // 'email' => 'required|email|exists:users|max:255',
            'branch_id' => 'required',
            // 'password' => 'required|min:6',
            'country_code' => 'required|min:1|max:6',
            'phone_number' => 'required|min:10',
            'profile_picture' => 'nullable|image',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $user = User::where('id', request('user_id'))->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'errors' => "User Not Found",
            ], 422);

        }

        $profile_picture = "";
        if ($request->hasfile('profile_picture')) {
            $file = $request->file('profile_picture');
            $profile_picture = time() . $file->getClientOriginalName();
            $file->move(public_path() . "/uploads/profile/", $profile_picture);
            $user->profile_picture = $profile_picture;
        }

        $user->last_name = $request->last_name;
        $user->first_name = $request->first_name;
        $user->name = $request->first_name . " " . $request->last_name;
        $user->country_code = $request->country_code;
        $user->phone = $request->phone_number;
        $user->email = $request->email;
        $user->branch_id = $request->branch_id;

        $user->save();

        return response()->json(['status' => true, 'message' => "User Updated successfully", "user" => $user]);

    }

    public function fetch_users()
    {
        $users = User::where('user_type', 'customer')->where('status', 'active')->get();
        return response()->json(['status' => true, 'message' => "Customer Fetch Successful", 'users' => $users]);
    }
    public function all_user()
    {
        $users = User::where('user_type', 'customer')->with('account_details')->get();
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

        Mail::send('emails.sendMail', ['messages' => request('message'), 'firstName' => $user->name, 'subject' => $request->subject], function ($message) use ($request, $user) {
            $message->to($user->email);
            $message->subject($request->subject);
        });

        return response()->json(['status' => true, 'message' => "Mail Sent Successful"]);

    }

    public function add_money(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|max:255',
            'currency' => 'required|max:255',
            'amount' => 'required|max:255',
            'description' => 'required|max:255',
            'date' => 'required|max:255',
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
            'notify' => "You are received " . $request->currency . " " . $request->amount . " from  " . $request->description,
            'sender_id' => '1',
            'created_at' => Carbon::create(request('date')),
            'updated_at' => Carbon::create(request('date')),
        ]);
        $user->account_details->add_balance($request->amount, $request->currency);

        Mail::to($user)->send(new TransactionMail($receiverTransaction, $user));
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
            'date' => 'required|max:255',
            // 'notify' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $user = User::where('id', request('user_id'))->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => "Can not Find User"]);
        }

//Check Balance
        $received = $user->transactions()->where('process', 'credit')->whereIn('status', ['approved', 'pending'])->where('currency', request('currency'))->sum('amount');
        $sent = $user->transactions()->where('process', 'debit')->whereIn('status', ['approved', 'pending'])->where('currency', request('currency'))->sum('amount');
        $balance_from_transaction_history = round(floatval($received) - floatval($sent), 2);
        $stored_balance = $user->account_details->balance($request->currency);
        if ($stored_balance != $balance_from_transaction_history) {
            return response()->json([
                'status' => false,
                'bb' => $balance_from_transaction_history,
                'sc' => $stored_balance,
                'message' => 'User balance and transaction balance does not match',
            ], 400);
        }

        $sub = $stored_balance - floatval($request->amount);
        if ($sub < 0) {
            return response()->json([
                'status' => false,
                'message' => 'User Does not have that amount',
            ], 400);
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
            'notify' => "You were debited " . $request->currency . " " . $request->amount . " ",
            'sender_id' => '1',
            'created_at' => Carbon::create(request('date')),
            'updated_at' => Carbon::create(request('date')),
        ]);

        $user->account_details->sub_balance($request->amount, $request->currency);

        Mail::to($user)->send(new TransactionMail($receiverTransaction, $user));
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

        if ($account->status == "active") {
            // $user->status = 'not_active';
            $account->status = 'not_active';
            $account->can_withdraw = 'not_active';

            $user->save();
            $account->save();
            Mail::to($user)->send(new AccountBlockedMail($user));

        } else {
            // $user->status = 'active';
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
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $user = User::where('id', request('user_id'))->with('account_details')->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => "Can not Find User"]);
        }

        $user->kyc_status = $user->kyc_status == 'yes' ? 'no' : 'yes';

        $user->save();

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

    public function toggle_card(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|max:255',
            'type' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $user = User::where('id', request('user_id'))->with('account_details')->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => "Can not Find User"]);
        }

        $account = AccountInfomation::where('user_id', $user->id)->first();

        if (request('type') == 'first') {
            $account->first_card_status = $account->first_card_status == "active" ? "not_active" : "active";
            $account->save();
        }

        if (request('type') == 'second') {
            $account->second_card_status = $account->second_card_status == "active" ? "not_active" : "active";
            $account->save();
        }

        return response()->json(['status' => true, 'message' => "Customer Fetch Successful", "user" => $user]);

    }

    public function update_card_limit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|max:255',
            'card' => 'required|max:255',
            'limit' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $user = User::where('id', request('user_id'))->with('account_details')->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => "Can not Find User"]);
        }

        $account = AccountInfomation::where('user_id', $user->id)->first();

        if (request('card') == 'first') {
            $account->first_card_balance = request('limit');
            $account->save();
        }

        if (request('card') == 'second') {
            $account->second_card_balance = request('limit');
            $account->save();
        }

        return response()->json(['status' => true, 'message' => "Customer Fetch Successful", "user" => $user]);

    }

}
