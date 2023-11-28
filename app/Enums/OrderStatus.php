<?php

namespace App\Enums;

enum OrderStatus: string
{

    /**
     *  Awaiting payment for the order.
     *
     * @var string
     */
    case PENDING = 'pending';

    /**
     * Payment for the order has been canceled.
     *
     */
    case CANCELLED = 'canceled';

    /**
     * Payment for the order is completed.
     *
     */
    case COMPLETED = 'completed';

    case IN_PROGRESS = 'in_progress';

    case IN_PROCESS = 'in_processing';


    public static function values()
    {
        return array_column(self::cases(), 'value');
    }
}
