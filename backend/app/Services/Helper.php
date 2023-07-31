<?php

namespace App\Services;

use App\Models\AccountInfomation;
use App\Models\GiftCard;
use App\Models\OtpCode;
use App\Models\Setting;
use App\Models\SupportTicket;
use App\Models\User;

class Helper
{
    public static function generate_temp_password($length = 10)
    {
        $code = substr(str_shuffle(str_repeat('01234567890qwertyuiopQWERTYUIOPasdfghjklASDFGHJKLzxcvbnmZXCVBNM', $length)), 0, $length);
        return $code;
    }
    public static function generate_deposit_ref($user_id)
    {
        $code = substr(str_shuffle(str_repeat('01234567890QWERTYUIOPASDFGHJKLZXCVBNM', 12)), 0, 12);
        return $code . "" . $user_id;
    }
    public static function generate_trans_ref($user_id)
    {
        $code = substr(str_shuffle(str_repeat('01234567890QWERTYUIOPASDFGHJKLZXCVBNM', 16)), 0, 16);
        return $code . "" . $user_id;
    }
    public static function generate_payment_ref($user_id)
    {
        $code = substr(str_shuffle(str_repeat('01234567890QWERTYUIOPASDFGHJKLZXCVBNM', 8)), 0, 8);
        return $code . "" . $user_id;
    }
    public static function generate_account_number()
    {
        $code = substr(str_shuffle(str_repeat('01234567890987654321', 10)), 0, 10);
        $check_one = AccountInfomation::where('account_number', $code)->first();
        $check_two = User::where('account_number', $code)->first();

        if ($check_one || $check_two) {
            self::generate_account_number();
        }
        return $code;
    }
    public static function generate_card_number()
    {
        $start = ['50', '51', '52', '53', '54', '55'];
        $selectStart = $start[rand(0, 5)];

        $code = $selectStart . '' . substr(str_shuffle(str_repeat('01234567890987654321', 14)), 0, 14);
        $check_one = AccountInfomation::where('first_card_number', $code)->orWhere('seconds_card_number', $code)->first();

        if ($check_one) {
            self::generate_card_number();
        }
        return $code;

    }
    public static function generate_ticket_ref()
    {
        $code = substr(str_shuffle(str_repeat('01234567890987654321', 5)), 0, 5);
        $code = "RBTK" . $code;
        $check_one = SupportTicket::where('ticket_ref', $code)->first();

        if ($check_one) {
            self::generate_ticket_ref();
        }
        return $code;

    }
    public static function generate_gift_card_code()
    {
        $code = substr(str_shuffle(str_repeat('01234567890QWERTYUIOPASDFGHJKLZXCVBNM', 6)), 0, 6);
        $code = "GICD" . $code;
        $check_one = GiftCard::where('code', $code)->first();

        if ($check_one) {
            self::generate_gift_card_code();
        }
        return $code;

    }
    public static function generate_otp()
    {
        $code = substr(str_shuffle(str_repeat('01234567890987654321', 6)), 0, 6);
        $check_one = OtpCode::where('code', $code)->first();

        if ($check_one) {
            self::generate_otp();
        }
        return $code;
    }
    public static function generate_login_otp()
    {
        $code = substr(str_shuffle(str_repeat('01234567890987654321', 6)), 0, 6);
        $check_one = User::where('login_otp', $code)->first();

        if ($check_one) {
            self::generate_login_otp();
        }
        return $code;

    }
    public static function require_login_otp()
    {
        $setting = Setting::where('name', 'login_otp')->first();
        if (!$setting) {
            return false;
        }
        if ($setting->value == 'active') {
            return true;
        }
        return false;
    }
}
