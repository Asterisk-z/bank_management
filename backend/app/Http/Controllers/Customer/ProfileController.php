<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class ProfileController extends Controller
{
    public function upload_profile(Request $request)
    {

        $v = Validator::make($request->all(), [
            'images' => 'required',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $attachment = "";
        if ($request->hasfile('images')) {
            $file = $request->file('images');
            $attachment = time() . $file->getClientOriginalName();
            $file->move(public_path() . "/uploads/profile_photo/", $attachment);

            $user = User::where('id', auth()->user()->id)->first();

            $user->profile_picture = $attachment;

            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Upload',
                'user' => $user,
            ], 200);

        }

    }
}
