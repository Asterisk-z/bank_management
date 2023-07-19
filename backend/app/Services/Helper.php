<?php

namespace App\Services;

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
}
