<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel;

use Dzangocart\Bundle\SubscriptionBundle\Propel\om\BasePriceQuery;

class PriceQuery extends BasePriceQuery
{
    public function getDefault()
    {
        return $this
            ->orderByRank()
            ->findOneByIsDefault(true);
    }
}
