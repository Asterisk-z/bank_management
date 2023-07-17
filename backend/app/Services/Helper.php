<?php

namespace App\Services;

class Helper
{
    public static function generate_temp_password($length = 10)
    {
        $code = substr(str_shuffle(str_repeat('01234567890qwertyuiopQWERTYUIOPasdfghjklASDFGHJKLzxcvbnmZXCVBNM', $length)), 0, $length);
        return $code;
    }
}
