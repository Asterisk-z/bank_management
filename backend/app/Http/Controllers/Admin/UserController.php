<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AdminNewCustomerNotification;
use App\Services\Helper;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    public function create_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'account_number' => 'required|max:30|unique:users',
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
            'account_number' => $request->account_number,
            'branch_id' => $request->branch_id,
            'profile_picture' => $profile_picture,
        ]);

        $user->notify((new AdminNewCustomerNotification)->delay(now()->addMinutes(2)));

        return response()->json(['status' => true, 'message' => "user created successfully", "user" => $user]);

    }

    public function all_user()
    {
        $users = User::where('user_type', 'customer')->get();
        return response()->json(['status' => true, 'message' => "Customer Fetch Successful", 'users' => $users]);
    }

    public function user($user_id)
    {
        $users = User::where('user_type', 'customer')->get();
        return response()->json(['status' => true, 'message' => "Customer Fetch Successful", 'users' => $users]);
    }
}
