<?php

declare(strict_types=1);

namespace App\Helper;

class Helper
{
    public const FIRST_CHARACTER_RUSSIAN_PHONE = '7';

    public static function formattingPhone(string $phone)
    {
        $phone = preg_replace('![^0-9]+!', '', $phone);

        if (mb_strlen($phone) <= 11) {
            $phone = substr_replace($phone, self::FIRST_CHARACTER_RUSSIAN_PHONE, 0, 1);
        }

        return $phone;
    }
}
