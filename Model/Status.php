<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Model;

class Status
{
    const READY = 1;
    const DISABLED = 7;
    const SUSPENDED = 8;
    const CLOSED = 9;

    public static function getStatuses()
    {
        return array(
            self::READY,
            self::DISABLED,
            self::SUSPENDED,
            self::CLOSED,
        );
    }
}
