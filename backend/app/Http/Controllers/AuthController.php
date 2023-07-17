<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
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
        $user = new User();
        $user->last_name = $request->lname;
        $user->first_name = $request->fname;
        $user->phone = $request->phone;
        $user->country_code = $request->country_code;
        $user->name = $request->lname . " " . $request->fname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

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
            return response()->json(['status' => true, "token" => $token, 'user' => auth()->user()], 200)->header('Authorization', $token);
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
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }
    /**
     * Return auth guard
     */
    private function guard()
    {
        return Auth::guard();
    }
}
