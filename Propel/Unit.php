<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel;

use Dzangocart\Bundle\SubscriptionBundle\Propel\om\BaseUnit;

class Unit extends BaseUnit
{
    function __construct($locale = 'en')
    {
        parent::__construct();
        $this->setLocale($locale);
    }
}
