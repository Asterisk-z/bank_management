<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\AccountInfomation;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class AccountController extends Controller
{
    //
    public function update_password(Request $request)
    {
        $user = auth()->user();

        $v = Validator::make($request->all(), [
            'old_password' => 'required|min:3',
            'password' => 'required|min:3|confirmed',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $user = User::where('id', auth()->user()->id)->first();

        $user->password = bcrypt(request('password'));

        $user->save();

        return response()->json(['status' => true, "user" => $user], 200);

    }
    public function toggle_card(Request $request)
    {
        $user = auth()->user();

        $v = Validator::make($request->all(), [
            'card' => 'required|min:3',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $user = User::where('id', auth()->user()->id)->first();

        $account = AccountInfomation::where('id', $user->id)->first();

        if ($request->card == 'first') {
            $account->first_card_status = $account->first_card_status == 'not_active' ? 'active' : 'not_active';
            $account->save();
        }

        if ($request->card == 'second') {
            $account->secind_card_status = $account->second_card_status == 'not_active' ? 'active' : 'not_active';
            $account->save();
        }

        return response()->json(['status' => true, "user" => $user], 200);

    }
    public function email_update(Request $request)
    {
        $user = auth()->user();

        $v = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }
    }
}
