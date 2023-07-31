<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Helper;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Str;
use Validator;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'lname' => 'required|min:3',
            'fname' => 'required|min:3',
            'country_code' => 'required|min:2|max:6',
            'phone' => 'required|min:10',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3|confirmed',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }
        $account_number = Helper::generate_account_number();
        $user = new User();
        $user->last_name = $request->lname;
        $user->first_name = $request->fname;
        $user->phone = $request->phone;
        $user->country_code = $request->country_code;
        $user->name = $request->lname . " " . $request->fname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $account_number = Helper::generate_account_number();
        $card_number = Helper::generate_card_number();
        $user->account_details()->create(['account_number' => $account_number, 'first_card_number' => $card_number]);

        $token = $this->guard()->attempt($request->only('email', 'password'));
        return response()->json(['status' => true, "token" => $token, 'user' => auth()->user()], 200);
    }
    /**
     * Login user and return a token
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {

            if (Helper::require_login_otp()) {

                $user = User::where('email', request('email'))->first();
                $otp = Helper::generate_login_otp();
                $user->login_otp = $otp;
                $user->otp_expires_at = now()->addMinutes(10);
                $user->save();

                Mail::send('emails.loginOtp', ['code' => $user->login_otp, 'firstName' => $user->name], function ($message) use ($user) {
                    $message->to($user->email);
                    $message->subject('Login OTP');
                });
                session(['login_email' => $user->email]);

                return response()->json(['status' => true, 'goto_otp' => true, 'email' => $user->email], 200);
            }
            session()->forget('login_email');
            session()->flush();

            return response()->json(['status' => true, "token" => $token, 'user' => auth()->user()], 200)->header('Authorization', $token);
        }
        return response()->json(['status' => false, 'error' => 'login_error'], 401);
    }

    /**
     * Login user and return a token
     */
    public function login_otp(Request $request)
    {
        // Check Email from request and email from session
        $user = User::where('email', request('email'))->where('login_otp', request('code'))->first();
        if (!$user) {
            return response()->json(['status' => false, 'error' => 'Wrong OTP'], 401);
        }

        if (!Carbon::create($user->otp_expires_at)->greaterThan(now())) {
            return response()->json(['status' => false, 'error' => 'OTP Expired'], 401);
        }

        if ($token = auth()->tokenById($user->id)) {

            session()->forget('login_email');

            session()->flush();

            return response()->json(['status' => true, "token" => $token, 'user' => $user], 200)->header('Authorization', $token);
        }
        return response()->json(['status' => false, 'error' => 'login_error'], 401);
    }
/**
 * Logout User
 */
    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.',
        ], 200);
    }
/**
 * Get authenticated user
 */
    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response()->json([
            'status' => 'success',
            'data' => $user,
        ]);
    }
/**
 * Refresh JWT token
 */
    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => true, "token" => $token, 'user' => auth()->user()], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }
/**
 * Return auth guard
 */
    public function guard()
    {
        return Auth::guard();
    }

    public function forgot_password(Request $request)
    {
        $v = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $url = config('app.front_url') . "password_reset/" . $token;

        Mail::send('emails.forgetPassword', ['token' => $url], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return response()->json(['status' => true, "message" => "Email Sent Successfully", 'url' => $url], 200);

    }

    public function check_token(Request $request)
    {
        $v = Validator::make($request->all(), [
            'token' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }
        ;

        $token = DB::table('password_resets')->where('token', $request->token)->first();

        if ($token) {
            return response()->json(['status' => true, "message" => "Reset token found", 'token' => $token], 200);

        } else {

            return response()->json(['status' => false, "message" => "Wrong Resent Token", 'token' => $token], 404);

        }

    }

    public function password_reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users|exists:password_resets',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token,
            ])
            ->first();

        if (!$updatePassword) {

            return response()->json(['status' => false, "message" => "Invalid token!"], 422);

        }

        $user = User::where('email', $request->email)->update(['password' => bcrypt($request->password)]);

        if ($user) {
            DB::table('password_resets')->where(['email' => $request->email])->delete();

            return response()->json(['status' => true, "message" => "Password updated successfully"], 200);

        }

    }
}
