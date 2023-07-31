<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiftCard;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class GiftcardController extends Controller
{
    //

    public function create_gift_card(Request $request)
    {
        $v = Validator::make($request->all(), [
            'user' => 'required',
            'amount' => 'required',
            'currency' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }
        $alluser = 'no';
        if (request('user') == 0) {
            $alluser = 'yes';
        }

        DB::beginTransaction();

        $git_code = Helper::generate_gift_card_code();

        GiftCard::create([
            'user_id' => $alluser == 'no' ? request('user') : null,
            'code' => $git_code,
            'currency' => request('currency'),
            'amount' => request('amount'),
            'is_general' => $alluser,
            'status' => 'active',
            'active_till' => now()->addDays(10),
        ]);

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => "Gift Card Created Successfully",
        ], 200);

    }

    public function list_gift_card()
    {
        $gift_cards = GiftCard::orderBy('created_at')->get();
        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'gift_cards' => $gift_cards,
        ], 200);
    }
    public function list_used_gift_card()
    {
        $gift_cards = GiftCard::where('status', 'used')
            ->orderBy('created_at')->get();
        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'gift_cards' => $gift_cards,
        ], 200);
    }

    public function list_active_gift_card()
    {
        $gift_cards = GiftCard::where('status', 'active')
            ->orderBy('created_at')->get();
        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'gift_cards' => $gift_cards,
        ], 200);
    }

    public function list_canceled_gift_card()
    {
        $gift_cards = GiftCard::whereIn('status', ['canceled', 'expired'])
            ->orderBy('created_at')->get();
        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'gift_cards' => $gift_cards,
        ], 200);
    }

    public function activate_giftcard(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $giftcard = GiftCard::where('id', request('id'))->first();
        if (!$giftcard) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to Activate',
            ], 200);

        }
        if ($giftcard->status == 'active') {
            return response()->json([
                'status' => false,
                'message' => 'Code Already Active',
            ], 200);
        }

        $giftcard->status = 'active';

        $giftcard->save();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
        ], 200);

    }

    public function cancel_giftcard(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $giftcard = GiftCard::where('id', request('id'))->first();
        if (!$giftcard) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to Activate',
            ], 200);

        }
        if ($giftcard->status == 'canceled') {
            return response()->json([
                'status' => false,
                'message' => 'Code Already canceled',
            ], 200);
        }

        $giftcard->status = 'canceled';

        $giftcard->save();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
        ], 200);

    }
}
