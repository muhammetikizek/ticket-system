<?php

namespace App\Enums;

enum PaymentStatus: string
{

    case SUCCESS = "success";

    case FAIL = "fail";

    public static function values()
    {
        return array_column(self::cases(), 'value');
    }
}
