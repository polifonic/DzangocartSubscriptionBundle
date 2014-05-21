<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel;

use Dzangocart\Bundle\SubscriptionBundle\Propel\om\BasePlanPeriod;

class PlanPeriod extends BasePlanPeriod
{

    public function __toString()
    {
        return $this->getCurrentTranslation()->getName();
    }
}
