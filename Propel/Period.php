<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel;

use Dzangocart\Bundle\SubscriptionBundle\Propel\om\BasePeriod;

class Period extends BasePeriod
{
    function __construct($locale = 'en')
    {
        parent::__construct();
        $this->setLocale($locale);
    }
}
