<?php

namespace App\Enums;

enum PaymentTypes: string
{

    case CASH = "cash";

    case BANK = "bank_transfer";

    case POS = "credit_card";

    public static function values()
    {
        return array_column(self::cases(), 'value');
    }

}
